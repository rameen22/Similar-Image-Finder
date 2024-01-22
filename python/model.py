import sys
import os
import numpy as np
from PIL import Image
import pickle
from keras.models import Sequential
from keras.layers import GlobalMaxPooling2D
from keras.applications.resnet50 import ResNet50, preprocess_input
from sklearn.neighbors import NearestNeighbors
from numpy.linalg import norm
import cv2
import shutil

# Placeholder for the dataset path
dataset_path = r'C:\xamppp\htdocs\imagefinder\Dataset'  # Remove the extra 'Dataset' here

file_path = r'C:\xamppp\htdocs\imagefinder\new_featureVector_file.pkl'
feature_list = np.array(pickle.load(open(file_path, 'rb')))
# Load the model and other necessary data
file_path2 = r'C:\xamppp\htdocs\imagefinder\all_filenames.pkl'
filenames = np.array(pickle.load(open(file_path2, 'rb')))

base_model = ResNet50(weights='imagenet', include_top=False, input_shape=(224, 224, 3))
base_model.trainable = False

model = Sequential([
    base_model,
    GlobalMaxPooling2D()
])

def save_uploaded_file(uploaded_file_path, destination_path):
    try:
        with open(destination_path, 'wb') as f:
            f.write(open(uploaded_file_path, 'rb').read())
        return 1
    except:
        return 0

def extract_features(img_path, model1):
    img1 = cv2.imread(img_path)
    img1 = cv2.resize(img1, (224, 224))
    img1 = np.array(img1)
    expand_img1 = np.expand_dims(img1, axis=0)
    pre_img1 = preprocess_input(expand_img1)
    result1 = model1.predict(pre_img1).flatten()
    normalized_result1 = result1 / norm(result1)
    return normalized_result1

def recommend(features1, feature_list1):
    neighbors = NearestNeighbors(n_neighbors=6, algorithm='brute', metric='euclidean')
    neighbors.fit(feature_list1)

    distances1, indices1 = neighbors.kneighbors([features1])

    return distances1, indices1
if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python model.py <image_path>")
    else:
        image_path = sys.argv[1]

        # Perform prediction on the given image
        features = extract_features(image_path, model)

        # check if features are too dissimilar
        threshold = 0.8
        dissimilarity = norm(feature_list - features, axis=1)
        if all(dissimilarity > threshold):
            print("No similar images found. Try again.")
        else:
            # recommendation
            distances, indices = recommend(features, feature_list)
            # Change the last line of your Python script
            result_paths = [os.path.normpath(filenames[i]) for i in indices[0]]
            # print the paths separated by a comma
            print(",".join(result_paths), end='')