from flask import Flask, flash, jsonify, request, redirect, url_for
from werkzeug.utils import secure_filename
import os, cv2, sys
import numpy as np

# import keras as k

PATH = os.getcwd()
# model=load_model('model/5-tuning-learning-rate-model.hdf5')
sourceFile = sys.argv[1]

print(sourceFile)

# test_image =cv2.imread('C:/xampp/htdocs/api-tenun/storage/public/img_src/DSC_0580.jpg')
test_image =cv2.imread(str(sourceFile))
test_image=cv2.cvtColor(test_image, cv2.COLOR_BGR2GRAY)
fm = cv2.Laplacian(test_image, cv2.CV_64F).var()
text = ""
if fm > 0 and fm <= 400:
    text = "Blur"
elif fm > 400 and fm <= 1500 :
    text = "Improve Image"
else :
    text = "Good"

result = str(text)
fp = open("result.txt", "w")
fp.write(result)
fp.close()
