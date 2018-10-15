from flask import Flask, flash, jsonify, request, redirect, url_for
from werkzeug.utils import secure_filename
import os, cv2, sys
import numpy as np

# import keras as k
from keras import backend as K
K.set_image_dim_ordering('th')
from keras.models import load_model
PATH = os.getcwd()
data_path = PATH +'/python_file/model'
model=load_model(data_path +'/5-tuning-learning-rate-model.hdf5')
# model=load_model('model/5-tuning-learning-rate-model.hdf5')
sourceFile = sys.argv[1]

print(sourceFile)

num_channel =1
names = ['Ulos Mangiring', 'Ulos Ragiidup', 'Ulos Sitoluntuho','Ulos Ragihotang', 'Ulos Harungguan', 'Ulos Sibolang', 'Ulos Bintang Maratur', 'Ulos Sadum']
img_rows=900
img_cols=900

# test_image =cv2.imread('C:/xampp/htdocs/api-tenun/storage/public/img_src/DSC_0580.jpg')
test_image =cv2.imread(str(sourceFile))
test_image=cv2.cvtColor(test_image, cv2.COLOR_BGR2GRAY)
test_image=cv2.resize(test_image,(img_rows,img_cols))
test_image = np.array(test_image)
test_image = test_image.astype('float32')
test_image /= 255
test_image= np.expand_dims(test_image, axis=0)
test_image= np.expand_dims(test_image, axis=0)


index_class_names = model.predict_classes(test_image)
result = str(names[index_class_names[0]])
fp = open("klasifikasi_good_ori.txt", "w")
fp.write(result)
fp.close()
K.clear_session()
