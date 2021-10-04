function imgQuilting4 = example(SourceFile, newFileName, matrix, warna)

    A = [1 2 3; 4 5 6; 7 8 9];
    A(:,:,2) = [10 11 12; 13 14 15; 16 17 18];
    B = [11 12 13; 14 15 16; 17 18 19];
    B(:,:,2) = [110 111 112; 113 114 115; 116 117 118];
    disp(A);
    disp(B);
    A(2:3, 2:3, :) = B(1:3,1:3,:);
    disp(A);
    pause(1000);

    tic;
    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%inisialisasi atribut
    texture = imread(SourceFile);
    %The third dimension is the number of colour planes
    %correspond how much of a color to use (primary color it seems to be)
    [height, width, dim] = size(texture);
    inputan = matrix;
    temp_height=height;
    temp_width=width;

    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%inisialisasi ukuran baru
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
    %810
    if(newSize > 810)
      newSize = 810;
    end

    %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%menghasilkan potongan motif untuk motif baru
    %motif awal size baru
    ukuran_new = imresize(texture,[newSize, newSize]);

    %disp('ukuran_new = ');
    %disp(ukuran_new);
    [height, width, dim] = size(ukuran_new);
    %operasi perkalian matriks, hasil matriks
    outsize = size(ukuran_new)*0.5;
    %disp('outsize = ');
    %disp(outsize);
    tilesize = floor(((width)/2)*0.8);
    %disp('tilesize = ');
    %disp(tilesize);
    overlapsize = (tilesize*2)- floor((width)/2);
    %disp('overlapsize = ');
    %disp(overlapsize);
    %pause(100);
    l = 1;
    isdebug = 0;
    i = 1;
    timerVal = toc;
    %disp(timerVal);
    tic;
    imgMirror_original = synthesize2(ukuran_new, outsize, tilesize, overlapsize, isdebug);
    timerVal = toc;
    %disp(imgMirror_original);
    %pause(100);
    %return;
    if(inputan < 1)
      disp('Inputan matrix sebaiknya lebih dari 0!');
      return;
    elseif(inputan == 1)
      x = imresize(imgMirror_original, [temp_height, temp_width]);
    else
      %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%variasi potongan motif
      imgMirror_Flip_vertical = flip(imgMirror_original,1);
      imgMirror_Flip_horizontal = flip(imgMirror_original,2);
      imgMirror_Flip_v_vertical = flip(imgMirror_Flip_vertical,2);

      %%%%%%%%%%%%%%%%%%%%%%%%%%gabung variasi potongan motif menjadi motif baru
      allDataUp = [];
      allDataBot = [];
      U = [];
      modulus=mod(inputan,2);
      if(modulus==0)
        %2,4
        %horzcat
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
          U = imgResUpper;
        end
      else
        %3
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
    %disp(timerVal);
    tic;
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
      imwrite(uint8(imgFullBerwarna),newFileName,'jpg')
    else
      imwrite(uint8(imgFullAsli),newFileName,'jpg')
    end
    timerVal = toc;
    %disp(timerVal);
    %pause(10);
  end
