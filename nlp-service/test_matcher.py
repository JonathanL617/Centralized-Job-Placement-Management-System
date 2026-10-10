import requests
import json

URL = "http://127.0.0.1:5000/match"

# Let's say this is what Laravel saved in the database for the student earlier
student_skills = ["Python", "Java", "Docker", "Agile", "SQL", "Teamwork"]

# And this is a new job posting that an Employer just created
job_description = """
We are looking for a Senior Backend Developer.
Requirements:
- Strong experience in Python and Go.
- Database management with SQL and MongoDB.
- Must know Docker and Kubernetes for containerization.
- Excellent Teamwork and Leadership skills required.
"""

payload = {
    "student_skills": student_skills,
    "job_text": job_description
}

print("Calculating Skill Match and Gap Analysis...")

try:
    response = requests.post(URL, json=payload)
    print("\nAPI Response:")
    print(json.dumps(response.json(), indent=2))
except Exception as e:
    print(f"Failed to connect: {e}")
