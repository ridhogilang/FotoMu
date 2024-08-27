import face_recognition
import sys
import json
import os

def extract_features(image_path):
    try:
        if not os.path.isfile(image_path):
            raise FileNotFoundError(f"File not found: {image_path}")

        print(f"Reading image from: {image_path}")  # Debug statement

        image = face_recognition.load_image_file(image_path)
        face_encodings = face_recognition.face_encodings(image)

        if face_encodings:
            print("Face encodings found")  # Debug statement
            return face_encodings[0].tolist()  # Convert to list for JSON serialization
        else:
            print("No face encodings found")  # Debug statement
            return []  # Return an empty list if no face is found

    except Exception as e:
        return {"error": str(e)}

if __name__ == "__main__":
    image_path = sys.argv[1]
    features = extract_features(image_path)
    print(json.dumps(features))  # Output the features as JSON
