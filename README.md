# Similar-Image-Finder

Image Finder is an image search and recommendation website by  using deep learning . This project allows users to upload an image, and the system retrieves and displays similar images from a pre-trained dataset. It leverages a feature extraction model based on ResNet50, enabling efficient and accurate image similarity matching.

1.Features:
Upload and Search: Users can upload an image through a user-friendly interface to find similar images within the dataset.

Deep Learning Model: The project integrates a deep learning model based on ResNet50 for feature extraction, providing robust representations of images.

Similarity Matching: Utilizes the k-nearest neighbors algorithm to find images with similar features, providing relevant recommendations.

Web Interface: A web-based frontend allows users to interact with the system easily. The interface displays the original query image and a grid of similar images.

Integration with PHP: The backend is integrated with PHP for handling file uploads, executing Python scripts, and displaying results on the web interface.

Dynamic Result Display: Results are dynamically displayed on the webpage, with the option to add recommended images to a user's library.

2.Tech Stack
Backend:

Python
Keras (with ResNet50)
scikit-learn (for k-nearest neighbors)

3.Frontend:

HTML
CSS (Bootstrap)
JavaScript

4.Server:
Apache (XAMPP)
Usage
Upload Image: Navigate to the "Find Similar Images" section and upload an image using the provided interface.
Search and Display: The system processes the image, extracts features, and displays similar images dynamically on the webpage.
Add to Library: Users have the option to add recommended images to their library for future reference.
