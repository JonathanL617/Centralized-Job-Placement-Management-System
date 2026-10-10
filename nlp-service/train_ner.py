import json
import spacy
from spacy.training.example import Example
import random
import os

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
data_path = os.path.join(BASE_DIR, 'training_data', 'Entity Recognition in Resumes.json')

with open(data_path, 'r', encoding='utf-8') as f:
    raw_data = [json.loads(line) for line in f if line.strip()]

nlp = spacy.blank("en")
ner = nlp.add_pipe("ner")
ner.add_label("SKILL")

training_data = []

for item in raw_data:
    text = item["content"]
    doc = nlp.make_doc(text)
    
    ents = []
    for ann in item["annotation"]:
        if len(ann["label"]) > 0 and ann["label"][0] == "Skills":
            start = ann["points"][0]["start"]
            # The Kaggle dataset occasionally cuts off the last character, so we add +1 as a buffer
            end = ann["points"][0]["end"] + 1
            
            # THE FIX: Tell SpaCy to snap the broken start/end numbers to actual word boundaries
            span = doc.char_span(start, end, label="SKILL", alignment_mode="contract")
            
            # If the span is valid and doesn't overlap with another skill we already grabbed
            if span is not None:
                ents.append(span)
                
    if ents:
        try:
            # Filter out overlapping entities (another common Kaggle dataset error)
            doc.ents = spacy.util.filter_spans(ents)
            
            # Create the Example and add it to our training list
            formatted_ents = [(e.start_char, e.end_char, e.label_) for e in doc.ents]
            example = Example.from_dict(doc, {"entities": formatted_ents})
            training_data.append(example)
        except Exception as e:
            pass

print(f"Cleaned up Kaggle data! Successfully aligned {len(training_data)} resumes.")

optimizer = nlp.begin_training()

for epoch in range(10):
    random.shuffle(training_data)
    losses = {}
    for example in training_data:
        nlp.update([example], sgd=optimizer, losses=losses)
    print(f"Epoch {epoch + 1}/10 complete. Loss: {losses.get('ner', 0):.4f}")

model_path = os.path.join(BASE_DIR, "skill_ner_model")
nlp.to_disk(model_path)
print(f"Model saved to {model_path}!")