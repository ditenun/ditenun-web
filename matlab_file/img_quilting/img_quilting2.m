function imgQuilting = example(SourceFile, newFileName, similarity_treshold)
  texture = imread(SourceFile);

  display(similarity_treshold)

  [height, width, dim] = size(texture);

  outsize = size(texture)*0.5;
  tilesize = floor((width/2)*0.8);  %256 * similarity_treshold =
  overlapsize = (tilesize*2)-floor(width/2);
  isdebug = 1;

  reset(RandStream.getDefaultStream,sum(100*clock))
      temp_1 = randi([3 50],1);
      temp_2 = randi([2 3],1);
      temp_3 = randi([(temp_1-1) (temp_1+1)],1);
      %temp = 10;

      overlapsize = overlapsize + (temp_1*2);
      tilesize = tilesize + temp_1;

  	tic;
          t2 = synthesize(texture,   outsize , tilesize, overlapsize, isdebug);

          imgMirrorLU = flipdim(t2,2);
          imgMirrorRB = flipdim(t2,1);
          imgMirrorLB = flipdim(imgMirrorLU,1);
          imgResUpper = cat(2,imgMirrorLU,t2);
          imgResBottom = cat(2,imgMirrorLB,imgMirrorRB);
          imgFull = cat(1, imgResBottom,imgResUpper);
    timerVal=toc;

    imwrite(uint8(imgFull), newFileName);
end
