import spacy
import os

# Load the trained model from disk
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
model_path = os.path.join(BASE_DIR, "skill_ner_model")
nlp = spacy.load(model_path)

print("=" * 60)
print("  SKILL EXTRACTION TEST - Custom NER Model")
print("=" * 60)

# Test with fake resume paragraphs the model has NEVER seen
test_resumes = [
    """
    John is a Full Stack Developer with 3 years of experience.
    He is proficient in Python, JavaScript, React, and Node.js.
    He has worked with PostgreSQL and MongoDB databases.
    Familiar with Docker, AWS, and CI/CD pipelines.
    """,
    """
    Recent graduate with a degree in Computer Science.
    Skills include Java, Spring Boot, HTML, CSS, and SQL.
    Experience with Machine Learning using TensorFlow and Pandas.
    Strong knowledge of Git version control and Agile methodology.
    """,
    """
    Marketing Manager with 5 years of experience in digital marketing.
    Proficient in SEO, Google Analytics, and social media management.
    Strong communication and leadership skills.
    """
]

for i, resume in enumerate(test_resumes, 1):
    print(f"\n--- Test Resume {i} ---")
    doc = nlp(resume)
    
    if doc.ents:
        print(f"  Skills Found ({len(doc.ents)}):")
        for ent in doc.ents:
            print(f"    -> {ent.text} (confidence label: {ent.label_})")
    else:
        print("  No skills detected.")

print("\n" + "=" * 60)
print("  Test complete!")
print("=" * 60)
