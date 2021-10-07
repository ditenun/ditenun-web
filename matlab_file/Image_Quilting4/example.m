texture = imread('C:\xampp\htdocs\api\matlab_file\Image_Quilting4\jsquares.gif');

t2 = synthesize(texture, 4 * size(texture), 12, 2);

figure(1)
imshow(texture);
figure(2)
imshow(uint8(t2));
imwrite(uint8(t2), 'newFileName.png', 'Transparency', [0 0 0]);