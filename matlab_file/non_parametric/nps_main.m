function non_parametric_sample(img_input, img_output, block_size)
image_read = imread(img_input);
input_image = im2double(image_read);

[height, width, dim] = size(image_read);
height_after = floor(height/2);
width_after = floor(width/2);
j=1;
while j<=5
    tic;
    %input parameter(input gambar, tinggi gambar, lebar gambar, besar blok yang diambil)
    t2 = synthesize_texture(input_image, height_after, width_after, block_size);
    imgMirrorRU = flipdim(t2,2);
    imgMirrorLB = flipdim(t2,1);
    imgMirrorRB = flipdim(imgMirrorRU,1);
    imgResUpper = cat(2,t2,imgMirrorRU);
    imgResBottom = cat(2,imgMirrorLB,imgMirrorRB);
    imgFull = cat(1,imgResUpper, imgResBottom);

	toc;

	imwrite(imgFull, img_output);
    j=j+1;

end;

return;
