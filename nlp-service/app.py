from flask import Flask, request, jsonify
import spacy
import os
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

app = Flask(__name__)

# 1. Initialize SpaCy Pipeline globally so it only loads once when the server starts
print("Initializing NLP Pipeline...")
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
nlp = spacy.load("en_core_web_sm")

# 2. Add the EntityRuler to the pipeline
ruler = nlp.add_pipe("entity_ruler", before="ner")

# 3. Load the comprehensive cross-industry skills dictionary
skills_file = os.path.join(BASE_DIR, "data", "jz_skill_patterns.jsonl")
if os.path.exists(skills_file):
    ruler.from_disk(skills_file)
    print(f"Loaded massive cross-industry skill dictionary!")
else:
    print("Warning: Skills dictionary not found. Please ensure data/jz_skill_patterns.jsonl exists.")

@app.route('/health', methods=['GET'])
def health_check():
    return jsonify({"status": "healthy", "service": "NLP Microservice"})

@app.route('/extract', methods=['POST'])
def extract_skills():
    """
    Expects JSON: {"resume_text": "I am a marketing manager skilled in SEO and Python..."}
    Returns JSON: {"skills": ["SEO", "Python"]}
    """
    data = request.get_json()
    
    if not data or 'resume_text' not in data:
        return jsonify({"error": "Missing 'resume_text' in request body"}), 400
        
    resume_text = data['resume_text']
    
    doc = nlp(resume_text)
    extracted_skills = list(set([ent.text for ent in doc.ents if ent.label_ == "SKILL"]))
    
    return jsonify({
        "status": "success",
        "skills": extracted_skills,
        "count": len(extracted_skills)
    })

@app.route('/match', methods=['POST'])
def match_skills():
    """
    Expects JSON: {"student_skills": ["Python", "Java"], "job_text": "We need Python and AWS..."}
    Returns JSON: Match Percentage, Job Skills, and Missing Skills (Gap Report)
    """
    data = request.get_json()
    if not data or 'student_skills' not in data or 'job_text' not in data:
        return jsonify({"error": "Missing 'student_skills' or 'job_text'"}), 400

    student_skills = data['student_skills']
    job_text = data['job_text']

    # 1. Extract skills from the Job Description using our NLP pipeline
    doc = nlp(job_text)
    job_skills = list(set([ent.text for ent in doc.ents if ent.label_ == "SKILL"]))

    if not job_skills:
        return jsonify({
            "status": "success",
            "match_percentage": 0.0,
            "job_skills": [],
            "missing_skills": []
        })

    # Lowercase everything for accurate comparison
    student_skills_lower = [s.lower() for s in student_skills]
    job_skills_lower = [s.lower() for s in job_skills]

    # 2. Identify Missing Skills (Skill Gap Analysis)
    missing_skills = [skill for skill in job_skills if skill.lower() not in student_skills_lower]

    # 3. Jaccard Similarity for Match Percentage
    # Jaccard Formula: (Intersection of Skills) / (Union of Skills)
    set_student = set(student_skills_lower)
    set_job = set(job_skills_lower)
    
    if not set_job and not set_student:
        match_percentage = 0.0
    else:
        intersection = set_student.intersection(set_job)
        union = set_student.union(set_job)
        jaccard_score = len(intersection) / len(union)
        match_percentage = round(jaccard_score * 100, 2)

    return jsonify({
        "status": "success",
        "match_percentage": match_percentage,
        "job_skills": job_skills,
        "missing_skills": missing_skills
    })

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)