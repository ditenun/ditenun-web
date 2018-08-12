# -*- coding: utf-8 -*-
"""
Created on Fri Jul  6 10:21:44 2018

@author: User
"""
import cv2, os
import sys

PATH = os.getcwd()
resource_path = sys.argv[2]
resource_path = resource_path[1:-1]
image = cv2.imread(resource_path)
image = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
fm = cv2.Laplacian(image, cv2.CV_64F).var()
text = "Not Blurry"
if fm < 100:
    text = "Blurry"

print(text)

# def detect_blur(path):
#     image = cv2.imread(path)
#     image = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
#     fm = cv2.Laplacian(image, cv2.CV_64F).var()
#     text = "Not Blurry"
#     if fm < 100:
#         text = "Blurry"

#
#     return text;
#
# if __name__ == '__main__':
#     resource_path = sys.argv[1]
#     resource_path = resource_path[1:-1]
#     detect_blur(resource_path)
