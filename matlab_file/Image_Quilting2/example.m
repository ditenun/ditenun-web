texture = imread('C:\xampp\htdocs\api\matlab_file\Image_Quilting2\S P2 3600 144 1 000 (1).png');
figure;
imshow(texture);
figure;
outsize = size(texture)*3;
tilesize = 12;
overlapsize = 3;
isdebug = 0;
t2 = synthesize(texture,   outsize , tilesize, overlapsize,isdebug);
imshow(uint8(t2))