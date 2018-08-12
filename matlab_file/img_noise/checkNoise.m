function checkNoise = example(sourceFile)
    currentimage = double(imread(sourceFile));
    level_noise = NoiseLevel(currentimage);


    fprintf(" : %.2f ",level_noise);

    fileID = fopen('result.txt','w');
    fprintf(fileID,'%.2f ',level_noise);
    fclose(fileID);
    
end
