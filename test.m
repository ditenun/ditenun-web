file = dir('C:\xampp\htdocs\api/public\img_src\param_temp\before\potongansadum0.jpeg');
input = {file.name}';
c = input;
for i = 1:length(file)
    fname = 'public\img_src\param_temp\before\potongansadum0.jpeg';
     a = imread(fname);
     b = imcrop(a,[140,65,150,150]);
     c{i} = strrep(fname, 'PolyU', 'crop');
     d = c{i};
     imwrite(b,'public\img_src\param_temp\after\potongansadum0.jpeg');
     imshow(b);
end

