function X = generateImg(sourceFile, newFileName)
    pathStringImage = 'log_generated/';
    pathImage = '../public/img_temp/';
    pathSource = '../public/img_src/';
    sourceFile = strcat(pathSource, sourceFile);
    newImagePath = strcat(pathImage, newFileName, '.jpg');

    generatedImg = imgQuilting(sourceFile, newImagePath);

    imwrite(uint8(generatedImg), newImagePath);
end
