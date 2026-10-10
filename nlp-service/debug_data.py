import json
import os

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
data_path = os.path.join(BASE_DIR, 'training_data', 'Entity Recognition in Resumes.json')
with open(data_path, 'r', encoding='utf-8') as f:
    raw_data = [json.loads(line) for line in f if line.strip()]

count = 0
for item in raw_data:
    for ann in item["annotation"]:
        if ann["label"][0] == "Skills":
            start = ann["points"][0]["start"]
            end = ann["points"][0]["end"]
            text_span = item["content"][start:end]
            json_text = ann["points"][0]["text"]
            print(f"Start/End gives: {repr(text_span)}")
            print(f"JSON text says : {repr(json_text)}")
            print("-" * 20)
            count += 1
            break
    if count >= 3:
        break
