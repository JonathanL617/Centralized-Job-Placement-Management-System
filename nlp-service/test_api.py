import requests
import json

# The URL of your new local NLP Flask API
URL = "http://127.0.0.1:5000/extract"

# A fake resume combining Tech, Marketing, Finance, and Soft Skills
fake_resume_payload = {
    "resume_text": """
    I am an experienced professional looking to transition into a hybrid technical/management role.
    
    Technical Skills:
    - Highly proficient in Python, Java, and Ruby on Rails.
    - Database architecture using PostgreSQL and MongoDB.
    - Familiar with cloud deployments on AWS and Microsoft Azure.
    
    Marketing & Business:
    - 4 years managing Google Analytics, SEO, and Content Strategy.
    - Experience in B2B Sales, CRM software, and Lead Generation.
    
    Finance:
    - Financial modeling, accounting, and payroll processing.
    - Experience with Excel macros and Quickbooks.
    
    Soft Skills:
    - Excellent Leadership, Teamwork, and Communication.
    - Time management and Agile project management.
    """
}

print(f"Sending Resume to NLP Service...")

try:
    response = requests.post(URL, json=fake_resume_payload)
    print("\nAPI Response:")
    print(json.dumps(response.json(), indent=2))
except Exception as e:
    print(f"Failed to connect: {e}")
