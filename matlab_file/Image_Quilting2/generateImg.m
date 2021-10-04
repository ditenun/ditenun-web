function X = generateImg(sourceFile, newFileName, square, P, inputan_matrix, warna)
    pathStringImage = 'log_generated/';
    pathImage = '../public/img_temp/';
    pathSource = '../public/img_src/';
    sourceFile = strcat(pathSource, sourceFile);
    newImagePath = strcat(pathImage, newFileName, '.jpg');

    generatedImg = main3_quilting(sourceFile, newFileName, square, inputan_matrix, warna);

    imwrite(uint8(generatedImg), newImagePath);
end
