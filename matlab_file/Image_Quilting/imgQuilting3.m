function imgQuilting3 = example(SourceFile, newFileName, matrix, warna)

    %inisialisasi atribut
    texture = imread(SourceFile);
    %The third dimension is the number of colour planes
    %correspond how much of a color to use (primary color it seems to be)
    [height, width, dim] = size(texture);
    inputan = matrix;
    temp_height=height;
    temp_width=width;

    mod_panjang=mod(height,2);
    mod_lebar=mod(width,2);
    newSize = height;
    if(width > height && mod_lebar ~= 0)
      newSize = width + 1;
    elseif(width > height)
        newSize = width;
    elseif(mod_panjang ~= 0)
        newSize = newSize + 1;
    end
    ukuran_new =imresize(texture,[newSize, newSize]);
    [height, width, dim] = size(ukuran_new);
    %operasi perkalian matriks, hasil matriks
    outsize = size(ukuran_new)*0.5;
    tilesize = floor(((width)/2)*0.8);
    overlapsize = (tilesize*2)- floor((width)/2);

    %for l = 1:2
    l = 1;
    isdebug = 1;
    i = 1;
    tic;
    
    imgMirror_original = synthesize(ukuran_new, outsize, tilesize, overlapsize, isdebug);

    if(inputan < 1)
      disp('Inputan matrix sebaiknya lebih dari 0!');
      return;
    elseif(inputan == 1)
      x = imresize(imgMirror_original, [temp_height, temp_width]);
    else
      imgMirror_Flip_vertical = flip(imgMirror_original,1);
      imgMirror_Flip_horizontal = flip(imgMirror_original,2);
      imgMirror_Flip_v_vertical = flip(imgMirror_Flip_vertical,2);

      allDataUp = [];
      allDataBot = [];
      U = [];
      modulus=mod(inputan,2);

      if(modulus==0)
        imgResUpper = cat(2,imgMirror_original,imgMirror_Flip_horizontal);
        imgResBottom = cat(2,imgMirror_Flip_vertical,imgMirror_Flip_v_vertical);
        for z = 1:(inputan/2)
          allDataUp = horzcat(allDataUp, imgResUpper);
        end
        for z = 1:(inputan/2)
          allDataBot = horzcat(allDataBot, imgResBottom);
        end
        for i = 1 : (inputan/2)
          imgGabungan = vertcat(allDataUp, allDataBot);
          U = vertcat(U,imgGabungan);
        end
      else
        imgResUpper = horzcat(imgMirror_original,imgMirror_Flip_horizontal,imgMirror_original);
        imgResBottom = horzcat(imgMirror_Flip_vertical,imgMirror_Flip_v_vertical,imgMirror_Flip_vertical);

        modInput=mod(inputan,3);
        if(modInput==0)
          for z = 1:(inputan/3)
              allDataUp = horzcat(allDataUp, imgResUpper);
          end
          for z = 1:(inputan/3)
              allDataBot = horzcat(allDataBot, imgResBottom);
          end
          for i = 1 : (inputan/3)
              imgGabungan = vertcat(allDataUp, allDataBot,allDataUp);
              U = vertcat(U,imgGabungan);
          end
        elseif(modInput==1)
          for z = 1:(inputan/3)
              allDataUp = horzcat( allDataUp,imgResUpper);
          end
          allDataUp = horzcat( imgMirror_Flip_horizontal,allDataUp);
          for z = 1:(inputan/3)
              allDataBot = horzcat(allDataBot, imgResBottom);
          end
          allDataBot=horzcat(imgMirror_Flip_v_vertical,allDataBot);
          for i = 1 : (inputan/3)
              imgGabungan = vertcat(allDataUp,allDataBot);
              U = vertcat(U,imgGabungan);
          end
          imgGabungan1 = vertcat(allDataUp,allDataBot);
          U = vertcat(U,imgGabungan1);
        elseif(modInput==2)
          for z = 1:(inputan/3)
              allDataUp = horzcat( imgResUpper,allDataUp);
          end
          allDataUp = horzcat(allDataUp, imgMirror_Flip_horizontal,imgMirror_original);
          for z = 1:(inputan/3)
              allDataBot = horzcat(allDataBot, imgResBottom);
          end
          allDataBot=horzcat(allDataBot,imgMirror_Flip_v_vertical,imgMirror_Flip_vertical);
          for i = 1 : (inputan/3)
              imgGabungan = vertcat(allDataUp,allDataBot,allDataUp);
              U = vertcat(U,imgGabungan);
          end
          imgGabungan1 = vertcat( allDataBot,allDataUp)
          U=vertcat(U,imgGabungan1);
        end
      end
      x = imresize(U, [temp_height, temp_width]);
    end

    timerVal=toc;
    imgFullAsli = x;

    newii=x*0;
    if(warna~=1 && warna~=4 && warna~=5)
      disp('Angka yang Anda masukkan salah pada pemilihan warna');
      return;
    elseif(warna==4)
        newii(:,:,1)=x(:,:,2);
        newii(:,:,2)=x(:,:,3);
        newii(:,:,3)=x(:,:,1);
    elseif(warna==5)
        newii(:,:,1)=x(:,:,1);
        newii(:,:,2)=x(:,:,1);
        newii(:,:,3)=x(:,:,1);
    end

    imgFullBerwarna = newii;

    overlapsize = overlapsize + (i*2);
    tilesize = tilesize + i;

    if(warna ~= 1)
      imwrite(uint8(imgFullBerwarna),strcat(newFileName, '.jpg'),'jpg')
    else
      imwrite(uint8(imgFullAsli),strcat(newFileName, '.jpg'),'jpg')
    end
  end
