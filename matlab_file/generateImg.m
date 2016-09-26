function X = generateImg(newFileName)
    pathStringImage = 'log_generated/';
    pathImage = '../public/img_temp/';
    pathSource = '../public/img_src/';
    sourceFile = strcat(pathSource, 'potongansadum0.jpg');
    stringImagePath = strcat(pathStringImage, newFileName, '.txt');
    newImagePath = strcat(pathImage, newFileName, '.jpg');

    generatedImg = imgQuilting(sourceFile, newImagePath);

    imwrite(uint8(generatedImg), newImagePath);
end
