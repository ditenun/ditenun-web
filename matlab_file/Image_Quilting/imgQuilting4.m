function imgQuilting = example(SourceFile, newFileName, matrix, warna)
    %%display(SourceFile)
    %%display(newFileName)

    texture = imread(SourceFile);
    [height, width, dim] = size(texture);
    inputan = matrix;
    modulus=mod(inputan,2);
    temp_height=0;
    temp_width=0;

    temp_height=height;
    temp_width=width;

    imshow(texture);

    %untuk inputan ukurannya ganjil
    mod_panjang=mod(height,2);
    mod_lebar=mod(width,2);
    %for l = 1:2
    if(mod_panjang ~= 0 && mod_lebar ~= 0)
        if(height>width)
            ukuran_new =imresize(texture,[(height+1), (height+1)]);
            %disp(ukuran_new)
            [height, width, dim] = size(ukuran_new);

            %%disp(size(ukuran_new))
            outsize = size(ukuran_new)*0.5;

            tilesize = floor(((width)/2)*0.8);
            overlapsize = (tilesize*2)- floor((width)/2);
        elseif(width>height)
            ukuran_new =imresize(texture,[(width+1), (width+1)]);
            %disp(ukuran_new)
            [height, width, dim] = size(ukuran_new);

            %disp(size(ukuran_new))
            outsize = size(ukuran_new)*0.5;

            tilesize = floor(((width)/2)*0.8);
            overlapsize = (tilesize*2)- floor((width)/2);
        else
            ukuran_new =imresize(texture,[(width+1), (height+1)]);
            %disp(ukuran_new)
            [height, width, dim] = size(ukuran_new);

            %%disp(size(ukuran_new))
            outsize = size(ukuran_new)*0.5;

            tilesize = floor(((width)/2)*0.8);
            overlapsize = (tilesize*2)- floor((width)/2);
        end
    elseif(mod_panjang == 0 && mod_lebar ~= 0)
        if(height>width)
            ukuran_new =imresize(texture,[(height), (height)]);
            %disp(ukuran_new)
            [height, width, dim] = size(ukuran_new);

            %%disp(size(ukuran_new))
            outsize = size(ukuran_new)*0.5;

            tilesize = floor(((width)/2)*0.8);
            overlapsize = (tilesize*2)- floor((width)/2);
        elseif(width>height)
            ukuran_new =imresize(texture,[(width+1), (width+1)]);
            %disp(ukuran_new)
            [height, width, dim] = size(ukuran_new);

            %%disp(size(ukuran_new))
            outsize = size(ukuran_new)*0.5;

            tilesize = floor(((width)/2)*0.8);
            overlapsize = (tilesize*2)- floor((width)/2);

        end
    elseif(mod_panjang ~= 0 && mod_lebar == 0)
        if(height>width)
            ukuran_new =imresize(texture,[(height+1), (height+1)]);
            %disp(ukuran_new)
            [height, width, dim] = size(ukuran_new);

            %%disp(size(ukuran_new))
            outsize = size(ukuran_new)*0.5;

            tilesize = floor(((width)/2)*0.8);
            overlapsize = (tilesize*2)- floor((width)/2);
        elseif(width>height)
            ukuran_new =imresize(texture,[(width), (width)]);
            %disp(ukuran_new)
            [height, width, dim] = size(ukuran_new);

            %%disp(size(ukuran_new))
            outsize = size(ukuran_new)*0.5;

            tilesize = floor(((width)/2)*0.8);
            overlapsize = (tilesize*2)- floor((width)/2);
        end
    else
        if(height>width)
            ukuran_new =imresize(texture,[(height), (height)]);
            %disp(ukuran_new)
            [height, width, dim] = size(ukuran_new);

            %%disp(size(ukuran_new))
            outsize = size(ukuran_new)*0.5;

            tilesize = floor(((width)/2)*0.8);
            overlapsize = (tilesize*2)- floor((width)/2);
        elseif(width>height)
            ukuran_new =imresize(texture,[(width), (width)]);
            %disp(ukuran_new)
            [height, width, dim] = size(ukuran_new);

            %%disp(size(ukuran_new))
            outsize = size(ukuran_new)*0.5;

            tilesize = floor(((width)/2)*0.8);
            overlapsize = (tilesize*2)- floor((width)/2);
        else
            ukuran_new =imresize(texture,[(height), (width)]);
            %disp(ukuran_new)
            [height, width, dim] = size(ukuran_new);

            %%disp(size(ukuran_new))
            outsize = size(ukuran_new)*0.5;

            tilesize = floor(((width)/2)*0.8);
            overlapsize = (tilesize*2)- floor((width)/2);
        end
    end

    %outsize = size(texture)*0.5;
    %tilesize = floor((width/2)*0.8);
    %overlapsize = (tilesize*2)-floor(width/2);

    isdebug = 1;
    %modulus adalah genap
      if(modulus==0 && inputan >=2)
          i = 1;
          while i <= 1
              j=1;
              while j <= 1
                  tic;
                  figure;
                  imgMirror_original = synthesize(ukuran_new,outsize , tilesize, overlapsize, isdebug);
                  %imgMirror_original =imresize(imgMirror_original_1,([panjang_output lebar_output]/length(theFiles)));
                  %imwrite(uint8(imgMirror_original),strcat(int2str(cek),' gambar generate dari- ',baseFileName,'(original).jpg'),'jpg');

                  imgMirror_Flip_vertical = flipdim(imgMirror_original,1);
                  imgMirror_Flip_horizontal = flipdim(imgMirror_original,2);
                  imgMirror_Flip_v_vertical = flipdim(imgMirror_Flip_vertical,2);

                  imgResUpper = cat(2,imgMirror_original,imgMirror_Flip_horizontal);
                  imgResBottom = cat(2,imgMirror_Flip_vertical,imgMirror_Flip_v_vertical);

                  allDataUp = [];
                  allDataBot = [];
                  for z = 1:(inputan/2)
                      allDataUp = horzcat(allDataUp, imgResUpper);
                  end

                  for z = 1:(inputan/2)
                      allDataBot = horzcat(allDataBot, imgResBottom);
                  end

                  U = [];
                  for i = 1 : (inputan/2)
                      imgGabungan = vertcat(allDataUp, allDataBot);
                      U = vertcat(U,imgGabungan);
                  end

                  timerVal=toc;
                  x =imresize(U,[temp_height temp_width]);

                  %warna asli
                  imgFullAsli = x;


                  newii=x*0;
                  if(warna==1)
                      newii(:,:,1)=x(:,:,1);
                      newii(:,:,1)=x(:,:,2);
                      newii(:,:,1)=x(:,:,3);
                  elseif(warna==2)
                      newii(:,:,2)=x(:,:,1);
                      newii(:,:,2)=x(:,:,2);
                      newii(:,:,2)=x(:,:,3);
                  elseif(warna==3)
                      newii(:,:,3)=x(:,:,1);
                      newii(:,:,3)=x(:,:,2);
                      newii(:,:,3)=x(:,:,3);
                  elseif(warna==4)
                      newii(:,:,1)=x(:,:,2);
                      newii(:,:,2)=x(:,:,3);
                      newii(:,:,3)=x(:,:,1);
                  elseif(warna==5)
                      newii(:,:,1)=x(:,:,1);
                      newii(:,:,2)=x(:,:,1);
                      newii(:,:,3)=x(:,:,1);
                  else
                      %disp('Angka yang Anda masukkan salah pada pemilihan warna');
                      break;
                  end
                  figure()
                  imshow(newii)
                  imgFullBerwarna = newii;

                  j = j + 1;
              end
              overlapsize = overlapsize + (i*2);
              tilesize = tilesize + i;
              i = i + 1;
          end

      %modulus adalah ganjil
      elseif(modulus==1 && inputan >=2)
          i = 1;
          while i <= 1
              j=1;
              while j <= 1
                  tic;
                  figure;
                  imgMirror_original = synthesize(ukuran_new,outsize , tilesize, overlapsize, isdebug);
                  %imgMirror_original = imresize(imgMirror_original_1,([panjang_output lebar_output]/length(theFiles)));

                  imgMirror_Flip_vertical = flipdim(imgMirror_original,1);
                  imgMirror_Flip_horizontal = flipdim(imgMirror_original,2);
                  imgMirror_Flip_v_vertical = flipdim(imgMirror_Flip_vertical,2);

                  imgResUpper = horzcat(imgMirror_original,imgMirror_Flip_horizontal,imgMirror_original);
                  imgResBottom = horzcat(imgMirror_Flip_vertical,imgMirror_Flip_v_vertical,imgMirror_Flip_vertical);

                  allDataUp = [];
                  allDataBot = [];
                  modInput=mod(inputan,3);

                  if(modInput==0)
                      for z = 1:(inputan/3)
                          allDataUp = horzcat(allDataUp, imgResUpper);
                      end

                      for z = 1:(inputan/3)
                          allDataBot = horzcat(allDataBot, imgResBottom);
                      end

                      U = [];
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

                      U = [];
                      for i = 1 : (inputan/3)
                          imgGabungan = vertcat(allDataUp,allDataBot);
                          U = vertcat(U,imgGabungan);
                      end
                      imgGabungan1 = vertcat(allDataUp,allDataBot)
                      U=vertcat(U,imgGabungan1);
                  elseif(modInput==2)
                      for z = 1:(inputan/3)
                          allDataUp = horzcat( imgResUpper,allDataUp);
                      end
                      allDataUp = horzcat(allDataUp, imgMirror_Flip_horizontal,imgMirror_original);

                      for z = 1:(inputan/3)
                          allDataBot = horzcat(allDataBot, imgResBottom);
                      end
                      allDataBot=horzcat(allDataBot,imgMirror_Flip_v_vertical,imgMirror_Flip_vertical);

                      U = [];
                      for i = 1 : (inputan/3)
                          imgGabungan = vertcat(allDataUp,allDataBot,allDataUp);
                          U = vertcat(U,imgGabungan);
                      end
                      imgGabungan1 = vertcat( allDataBot,allDataUp)
                      U=vertcat(U,imgGabungan1);
                  end


                  timerVal=toc;
                  x =imresize(U,[temp_height temp_width]);
                  imgFullAsli = x;


                  newii=x*0;
                  if(warna==1)
                      newii(:,:,1)=x(:,:,1);
                      newii(:,:,1)=x(:,:,2);
                      newii(:,:,1)=x(:,:,3);
                  elseif(warna==2)
                      newii(:,:,2)=x(:,:,1);
                      newii(:,:,2)=x(:,:,2);
                      newii(:,:,2)=x(:,:,3);
                  elseif(warna==3)
                      newii(:,:,3)=x(:,:,1);
                      newii(:,:,3)=x(:,:,2);
                      newii(:,:,3)=x(:,:,3);
                  elseif(warna==4)
                      newii(:,:,1)=x(:,:,2);
                      newii(:,:,2)=x(:,:,3);
                      newii(:,:,3)=x(:,:,1);
                  elseif(warna==5)
                      newii(:,:,1)=x(:,:,1);
                      newii(:,:,2)=x(:,:,1);
                      newii(:,:,3)=x(:,:,1);
                  else
                      %disp('Angka yang Anda masukkan salah pada pemilihan warna');
                      break;
                  end

                  figure()
                  imshow(newii)
                  %imwrite(uint8(newii),strcat('warna,',baseFileName),'png');
                  imgFullBerwarna = newii;


                  j = j + 1;
              end
              overlapsize = overlapsize + (i*2);
              tilesize = tilesize + i;
              i = i + 1;
          end
          elseif(modulus==1||modulus==0 && inputan ==1)
          i = 1;
          while i <= 1
              j=1;
              while j <= 1
                  tic;
                  figure;
                  imgMirror_original = synthesize(ukuran_new,outsize , tilesize, overlapsize, isdebug);
                  %imgMirror_original = imresize(imgMirror_original_1,([panjang_output lebar_output]/length(theFiles)));
                  %imwrite(uint8(imgMirror_original),baseFileName,'png');


                  x =imresize(imgMirror_original,[temp_height temp_width]);

                  imgFullAsli = x;

                  newii=x*0;
                  if(warna==1)
                      newii(:,:,1)=x(:,:,1);
                      newii(:,:,1)=x(:,:,2);
                      newii(:,:,1)=x(:,:,3);
                  elseif(warna==2)
                      newii(:,:,2)=x(:,:,1);
                      newii(:,:,2)=x(:,:,2);
                      newii(:,:,2)=x(:,:,3);
                  elseif(warna==3)
                      newii(:,:,3)=x(:,:,1);
                      newii(:,:,3)=x(:,:,2);
                      newii(:,:,3)=x(:,:,3);
                  elseif(warna==4)
                      newii(:,:,1)=x(:,:,2);
                      newii(:,:,2)=x(:,:,3);
                      newii(:,:,3)=x(:,:,1);
                  elseif(warna==5)
                      newii(:,:,1)=x(:,:,1);
                      newii(:,:,2)=x(:,:,1);
                      newii(:,:,3)=x(:,:,1);
                  else
                      %disp('Angka yang Anda masukkan salah pada pemilihan warna');
                      break;
                  end

                  figure()
                  imshow(newii)
                  imgFullBerwarna = newii;
                  %imwrite(uint8(newii),strcat('warna,',baseFileName),'png');

                  j = j + 1;
              end
              overlapsize = overlapsize + (i*2);
              tilesize = tilesize + i;
              i = i + 1;
          end
      else
          %disp('Inputan matrix sebaiknya lebih dari 0!');
      end


      if(warna ~= 1)
            imwrite(uint8(imgFullBerwarna), strcat(newFileName, '.jpg'),'jpg')
        else
            imwrite(uint8(imgFullAsli), strcat(newFileName, '.jpg'),'jpg')
        end
  end
