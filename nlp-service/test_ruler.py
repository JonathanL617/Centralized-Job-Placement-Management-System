import spacy

# 1. Load the standard English model
print("Loading SpaCy model...")
nlp = spacy.load("en_core_web_sm")

# 2. Add the EntityRuler to the pipeline
# We put it 'before' the default 'ner' so our exact matches get priority
ruler = nlp.add_pipe("entity_ruler", before="ner")

# 3. Define our dictionary of known skills
# In the final app, this would be loaded from a massive CSV or JSON file
patterns = [
    {"label": "SKILL", "pattern": "Python"},
    {"label": "SKILL", "pattern": "JavaScript"},
    {"label": "SKILL", "pattern": [{"LOWER": "react"}]}, # Case-insensitive match for "react" or "React"
    {"label": "SKILL", "pattern": "Node.js"},
    {"label": "SKILL", "pattern": "PostgreSQL"},
    {"label": "SKILL", "pattern": "MongoDB"},
    {"label": "SKILL", "pattern": "Docker"},
    {"label": "SKILL", "pattern": "AWS"},
    {"label": "SKILL", "pattern": "CI/CD"},
    {"label": "SKILL", "pattern": "Java"},
    {"label": "SKILL", "pattern": [{"LOWER": "spring"}, {"LOWER": "boot"}]}, # Matches "Spring Boot"
    {"label": "SKILL", "pattern": "HTML"},
    {"label": "SKILL", "pattern": "CSS"},
    {"label": "SKILL", "pattern": "SQL"},
    {"label": "SKILL", "pattern": [{"LOWER": "machine"}, {"LOWER": "learning"}]}, # Matches "Machine Learning"
    {"label": "SKILL", "pattern": "TensorFlow"},
    {"label": "SKILL", "pattern": "Pandas"},
    {"label": "SKILL", "pattern": "Git"},
    {"label": "SKILL", "pattern": "Agile"},
    {"label": "SKILL", "pattern": "SEO"},
    {"label": "SKILL", "pattern": "Google Analytics"}
]

# Add the patterns to the ruler
ruler.add_patterns(patterns)

print("\n" + "=" * 60)
print("  SKILL EXTRACTION TEST - Rule-Based EntityRuler")
print("=" * 60)

# 4. Test with the exact same fake resumes from earlier!
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
    
    # Filter to only show our custom "SKILL" entities
    skills_found = [ent.text for ent in doc.ents if ent.label_ == "SKILL"]
    
    if skills_found:
        print(f"  Skills Found ({len(skills_found)}):")
        for skill in skills_found:
            print(f"    -> {skill}")
    else:
        print("  No skills detected.")

print("\n" + "=" * 60)
print("  Test complete!")
print("=" * 60)
