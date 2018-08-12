myFolder = 'C:\xampp\htdocs\ModulTerbaru\api-tenun\matlab_file\NPS\image';
if ~isdir(myFolder)
  errorMessage = sprintf('Error: Folder tidak ada Link url salah:\n%s', myFolder);
  uiwait(warndlg(errorMessage));
  return;
end
filePattern = fullfile(myFolder, '*.jpg');
theFiles = dir(filePattern);

square=input('Pilihan : \n1.Square\n2.Not Square Horizontal\n3.Not Square Vertical\nPilih = ');
if(square==1)
    panjang_output=input('Ukuran output yang diinginkan, Panjang & Lebar = ');
    lebar_output=panjang_output;
    %menentukan matrix
    inputan=input('Banyak Matrix(matrix * matrix) yang diinginkan = ');
    warna=input('Pilih warna lain yang ansda inginkan.\n1.Merah\n2.Hijau\n3.Biru\n4.RGB\n5.Hitam Putih\nPilihan = ');
    modulus=mod(inputan,2);

    cek=0;
    for k = 1 : length(theFiles)
      cek = cek+1;
      baseFileName = theFiles(k).name;
      fullFileName = fullfile(myFolder, baseFileName);
      fprintf(1, 'Now reading %s\n', fullFileName);
      texture=imread( fullfile( myFolder, baseFileName));
      %code buat texture dan menyatukan gambar
      %figure;
      [height, width, dim] = size(texture);

      
        height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
      
      %imshow(texture);

      %untuk inputan ukurannya ganjil
      mod_panjang=mod(height,2);
      mod_lebar=mod(width,2);
      if(mod_panjang ~= 0 && mod_lebar ~= 0)
          if(height>width)
              ukuran_new =imresize(texture,[(height+1), (height+1)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
              height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          elseif(width>height)
              ukuran_new =imresize(texture,[(width+1), (width+1)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              disp(size(ukuran_new))
              height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          else
              ukuran_new =imresize(texture,[(width+1), (height+1)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
              height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          end
      elseif(mod_panjang == 0 && mod_lebar ~= 0)
          if(height>width)
              ukuran_new =imresize(texture,[(height), (height)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
             height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          elseif(width>height)
              ukuran_new =imresize(texture,[(width+1), (width+1)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
            height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          
          end
      elseif(mod_panjang ~= 0 && mod_lebar == 0)
          if(height>width)
              ukuran_new =imresize(texture,[(height+1), (height+1)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
             height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          elseif(width>height)
              ukuran_new =imresize(texture,[(width), (width)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
              height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          end
      else
          if(height>width)
              ukuran_new =imresize(texture,[(height), (height)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
              height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          elseif(width>height)
              ukuran_new =imresize(texture,[(width), (width)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
             height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          else
              ukuran_new =imresize(texture,[(height), (width)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
              height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          end
      end    
      
      
      isdebug = 1;
        
      %modulus adalah genap
        if(modulus==0 && inputan >=2)
            i = 1; 
            while i <= 1 
                j=1;
                while j <= 1
                    tic;
                    %figure;
                    imgMirror_original = synthesize_texture(ukuran_new, height_after, width_after, 4);
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
                    x =imresize(U,[panjang_output lebar_output]);
                    imwrite(uint8(x),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(FullGabungan).jpg'),'jpg');
                      
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
                        disp('Angka yang Anda masukkan salah pada pemilihan warna');
                        break;
                    end
                    figure()
                    imshow(newii)
                    imwrite(uint8(newii),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(FullGabunganBedaWarna).jpg'),'jpg');

                    j = j + 1;
                end 
                i = i + 1;
            end 
        
        %modulus adalah ganjil
        elseif(modulus==1 && inputan >=2)
            i = 1; 
            while i <= 1 
                j=1;
                while j <= 1
                    tic;
                    %figure;
					imgMirror_original = synthesize_texture(ukuran_new, height_after, width_after, 4);
                    %imgMirror_original = imresize(imgMirror_original_1,([panjang_output lebar_output]/length(theFiles)));
                    %imwrite(uint8(imgMirror_original),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(original).jpg'),'jpg');
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
                    x =imresize(U,[panjang_output lebar_output]);
                    imwrite(uint8(x),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(FullGabungan).jpg'),'jpg');
                    
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
                        disp('Angka yang Anda masukkan salah pada pemilihan warna');
                        break;
                    end
                    figure()
                    imshow(newii)
                   
                    imwrite(uint8(newii),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(FullGabunganBedaWarna).jpg'),'jpg');


                    j = j + 1;
                end 
                i = i + 1;
            end
        elseif(modulus==0||modulus==1 && inputan ==1 )
            i = 1; 
            while i <= 1 
                j=1;
                while j <= 1
                    tic;
                    %figure;
					imgMirror_original = synthesize_texture(ukuran_new, height_after, width_after, 4);
                    
                    timerVal=toc;
                    x =imresize(imgMirror_original,[panjang_output lebar_output]);
                    imwrite(uint8(x),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(FullGabungan).jpg'),'jpg');
                      
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
                        disp('Angka yang Anda masukkan salah pada pemilihan warna');
                        break;
                    end
                    figure()
                    imshow(newii)
                    imwrite(uint8(newii),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(FullGabunganBedaWrna).jpg'),'jpg');

                    j = j + 1;
                end 
                i = i + 1;
            end 

        else
            disp('Inputan matrix sebaiknya lebih dari 0!');    
            break;
        end
        
        
    end
elseif(square==2)
    inputan=input('Banyak Matrix(matrix * matrix) yang diinginkan = ');
    warna=input('Pilih warna lain yang ansda inginkan.\n1.Merah\n2.Hijau\n3.Biru\n4.RGB\n5.Hitam Putih\nPilihan = ');
    modulus=mod(inputan,2);

    cek=0;
    for k = 1 : length(theFiles)
      cek = cek+1;
      baseFileName = theFiles(k).name;
      fullFileName = fullfile(myFolder, baseFileName);
      fprintf(1, 'Now reading %s\n', fullFileName);
      texture=imread( fullfile( myFolder, baseFileName));
      %code buat texture dan menyatukan gambar
      %figure;
      [height, width, dim] = size(texture);

      
     height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
      
      %imshow(texture);

      %untuk inputan ukurannya ganjil
      mod_panjang=mod(height,2);
      mod_lebar=mod(width,2);
      if(mod_panjang ~= 0 && mod_lebar ~= 0)
          if(height>width)
              ukuran_new =imresize(texture,[(height+1), (height+1)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
              height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          elseif(width>height)
              ukuran_new =imresize(texture,[(width+1), (width+1)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

             height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          else
              ukuran_new =imresize(texture,[(width+1), (height+1)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
              height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          end
      elseif(mod_panjang == 0 && mod_lebar ~= 0)
          if(height>width)
              ukuran_new =imresize(texture,[(height), (height)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
              height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          elseif(width>height)
              ukuran_new =imresize(texture,[(width+1), (width+1)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
             height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          
          end
      elseif(mod_panjang ~= 0 && mod_lebar == 0)
          if(height>width)
              ukuran_new =imresize(texture,[(height+1), (height+1)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
              height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          elseif(width>height)
              ukuran_new =imresize(texture,[(width), (width)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
             height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          end
      else
          if(height>width)
              ukuran_new =imresize(texture,[(height), (height)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
             height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          elseif(width>height)
              ukuran_new =imresize(texture,[(width), (width)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
             height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          else
              ukuran_new =imresize(texture,[(height), (width)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
             height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          end
      end    
      isdebug = 1;
      %modulus adalah genap
        if(modulus==0 && inputan >=2)
            i = 1; 
            while i <= 1 
                j=1;
                while j <= 1
                    tic;
                    %figure;
					imgMirror_original = synthesize_texture(ukuran_new, height_after, width_after, 4);
                    
                    %imgMirror_original =imresize(imgMirror_original_1,([panjang_output lebar_output]/length(theFiles)));
                    %imwrite(uint8(imgMirror_original),strcat(int2str(cek),' gambar generate dari- ',baseFileName,'(original).jpg'),'jpg');

                    imgMirror_Flip_vertical = flipdim(imgMirror_original,1);
                    imgMirror_Flip_horizontal = flipdim(imgMirror_original,2);
                    imgMirror_Flip_v_vertical = flipdim(imgMirror_Flip_vertical,2);

                    imgResUpper = horzcat(imgMirror_original,imgMirror_Flip_horizontal);
                    imgResBottom = horzcat(imgMirror_Flip_vertical,imgMirror_Flip_v_vertical);

                    allDataUp = [];
                    allDataBot = [];
                    for z = 1:(inputan/2)
                        allDataUp = horzcat(allDataUp, imgResUpper);
                    end

                    for z = 1:(inputan/2)
                        allDataBot = horzcat(allDataBot, imgResBottom);
                    end
    
                    U = vertcat(allDataUp,allDataBot);   
                    
                    timerVal=toc;
                    x =imresize(U,[panjang_output lebar_output]);
                    imwrite(uint8(U),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(FullGabungan).jpg'),'jpg');

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
                        disp('Angka yang Anda masukkan salah pada pemilihan warna');
                        break;
                    end
                    figure()
                    imshow(newii)
                    
                    imwrite(uint8(newii),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(FullGabunganBedaWarna).jpg'),'jpg');

                    j = j + 1;
                end 
                i = i + 1;
            end 
        %modulus adalah ganjil
        elseif(modulus==1 && inputan >=2)
            i = 1; 
            while i <= 1 
                j=1;
                while j <= 1
                    tic;
                    %figure;
                    imgMirror_original = synthesize_texture(ukuran_new, height_after, width_after, 4);
					
                    %imgMirror_original = imresize(imgMirror_original_1,([panjang_output lebar_output]/length(theFiles)));
                    %imwrite(uint8(imgMirror_original),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(original).jpg'),'jpg');
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
                            imgGabungan = horzcat(allDataUp, allDataBot,allDataUp);   
                        end
                        U = vertcat(allDataUp,allDataBot);
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
                            imgGabungan = horzcat(allDataUp,allDataBot);    
                            %U = vertcat(U,imgGabungan);
                        end
                        
                        U = vertcat(allDataUp,allDataBot)
                        %U=vertcat(U,imgGabungan1);
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
                            imgGabungan = horzcat(allDataUp,allDataBot,allDataUp);   
                            %U = vertcat(U,imgGabungan);
                        end
                        
                        U = vertcat( allDataBot,allDataUp)
                        
                    end


                    timerVal=toc;
                    x =imresize(U,[panjang_output lebar_output]);
                    imwrite(uint8(U),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(FullGabungan).jpg'),'jpg');


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
                        disp('Angka yang Anda masukkan salah pada pemilihan warna');
                        break;
                    end
                    figure()
                    imshow(newii)

                    imwrite(uint8(newii),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(FullGabunganBedaWarna).jpg'),'jpg');


                    j = j + 1;
                end 
                i = i + 1;
            end
            elseif(modulus==0||modulus==1 && inputan ==1 )
            i = 1; 
            while i <= 1 
                j=1;
                while j <= 1
                    tic;
                    %figure;
                    imgMirror_original = synthesize_texture(ukuran_new, height_after, width_after, 4);
                    timerVal=toc;
                    x =imresize(imgMirror_original,[panjang_output lebar_output]);
                    imwrite(uint8(x),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(FullGabungan).jpg'),'jpg');
                      
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
                        disp('Angka yang Anda masukkan salah pada pemilihan warna');
                        break;
                    end
                    figure()
                    imshow(newii)
                    imwrite(uint8(newii),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(FullGabungan).jpg'),'jpg');

                    j = j + 1;
                end 
                i = i + 1;
            end 

        else
            disp('Inputan matrix sebaiknya lebih dari 0!');    
            break;
        end
    end
elseif(square==3)
    inputan=input('Banyak Matrix(matrix * matrix) yang diinginkan = ');
    warna=input('Pilih warna lain yang ansda inginkan.\n1.Merah\n2.Hijau\n3.Biru\n4.RGB\n5.Hitam Putih\nPilihan = ');
    modulus=mod(inputan,2);

    cek=0;
    for k = 1 : length(theFiles)
      cek = cek+1;
      baseFileName = theFiles(k).name;
      fullFileName = fullfile(myFolder, baseFileName);
      fprintf(1, 'Now reading %s\n', fullFileName);
      texture=imread( fullfile( myFolder, baseFileName));
      %code buat texture dan menyatukan gambar
      %figure;
      [height, width, dim] = size(texture);

      
     height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
      %imshow(texture);

      %untuk inputan ukurannya ganjil
      mod_panjang=mod(height,2);
      mod_lebar=mod(width,2);
      if(mod_panjang ~= 0 && mod_lebar ~= 0)
          if(height>width)
              ukuran_new =imresize(texture,[(height+1), (height+1)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
             height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          elseif(width>height)
              ukuran_new =imresize(texture,[(width+1), (width+1)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

             height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
              
          else
              ukuran_new =imresize(texture,[(width+1), (height+1)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
             height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          end
      elseif(mod_panjang == 0 && mod_lebar ~= 0)
          if(height>width)
              ukuran_new =imresize(texture,[(height), (height)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
              height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          elseif(width>height)
              ukuran_new =imresize(texture,[(width+1), (width+1)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
             height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          
          end
      elseif(mod_panjang ~= 0 && mod_lebar == 0)
          if(height>width)
              ukuran_new =imresize(texture,[(height+1), (height+1)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
             height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          elseif(width>height)
              ukuran_new =imresize(texture,[(width), (width)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
              height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          end
      else
          if(height>width)
              ukuran_new =imresize(texture,[(height), (height)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
             height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          elseif(width>height)
              ukuran_new =imresize(texture,[(width), (width)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
             height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          else
              ukuran_new =imresize(texture,[(height), (width)]);
              disp(ukuran_new)
              [height, width, dim] = size(ukuran_new);

              %disp(size(ukuran_new))
              height_after = floor(height/2);
		width_after = floor(width/2);
		j=1;
          end
      end    
      
      isdebug = 1;
      %modulus adalah genap
        if(modulus==0 && inputan >=2)
            i = 1; 
            while i <= 1 
                j=1;
                while j <= 1
                    tic;
                    %figure;
					imgMirror_original = synthesize_texture(ukuran_new, height_after, width_after, 4);
                    %imwrite(uint8(imgMirror_original),strcat(int2str(cek),' gambar generate dari- ',baseFileName,'(original).jpg'),'jpg');

                    imgMirror_Flip_vertical = flipdim(imgMirror_original,1);
                    imgMirror_Flip_horizontal = flipdim(imgMirror_original,2);
                    imgMirror_Flip_v_vertical = flipdim(imgMirror_Flip_vertical,2);

                    imgResUpper = horzcat(imgMirror_original,imgMirror_Flip_horizontal);
                    imgResBottom = horzcat(imgMirror_Flip_vertical,imgMirror_Flip_v_vertical);

                    allDataUp = [];
                    for z = 1:(inputan)
                        allDataUp = vertcat(imgResUpper, imgResBottom);
                    end

                    
                    U=[];
                    U = vertcat(allDataUp,allDataUp);   
                    
                    timerVal=toc;
                    x =imresize(U,[panjang_output lebar_output]);
                    imwrite(uint8(U),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(FullGabungan).jpg'),'jpg');

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
                        disp('Angka yang Anda masukkan salah pada pemilihan warna');
                        break;
                    end
                    figure()
                    imshow(newii)

                    imwrite(uint8(newii),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(FullGabunganBedaWarna).jpg'),'jpg');

                    j = j + 1;
                end 
                i = i + 1;
            end 
        %modulus adalah ganjil
        elseif(modulus==1 && inputan >=2)
            i = 1; 
            while i <= 1 
                j=1;
                while j <= 1
                    tic;
                    %figure;
					imgMirror_original = synthesize_texture(ukuran_new, height_after, width_after, 4);
                    %imgMirror_original = imresize(imgMirror_original_1,([panjang_output lebar_output]/length(theFiles)));
                    %imwrite(uint8(imgMirror_original),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(original).jpg'),'jpg');
                    imgMirror_Flip_vertical = flipdim(imgMirror_original,1);
                    imgMirror_Flip_horizontal = flipdim(imgMirror_original,2);
                    imgMirror_Flip_v_vertical = flipdim(imgMirror_Flip_vertical,2);

                    imgResUpper = horzcat(imgMirror_original,imgMirror_Flip_horizontal);
                    imgResBottom = horzcat(imgMirror_Flip_vertical,imgMirror_Flip_v_vertical);

                    allDataUp = [];
                    allDataBot = [];
                    modInput=mod(inputan,3);

                    if(modInput==0)
                        allDataUp = [];
                        U=[];
                        allDataUp = vertcat(imgResUpper, imgResBottom,imgResUpper);
                        for z = 1:(inputan/3)
                            U = vertcat(U,allDataUp);
                        end
                    elseif(modInput==1)
                        allDataUp = [];
                        U=[];
                        allDataUp = vertcat(imgResUpper, imgResBottom);
                        for z = 1:(inputan/2)
                            U = vertcat(U,allDataUp);
                        end
                        U = vertcat(U, imgResUpper);

                    elseif(modInput==2)
                        allDataUp = [];
                        U=[];
                        allDataUp = vertcat(imgResUpper, imgResBottom);
                        for z = 1:(inputan/2)
                            U = vertcat(U,allDataUp);
                        end
                        U = vertcat(U, imgResUpper);
                    end


                    timerVal=toc;
                    x =imresize(U,[panjang_output lebar_output]);
                    imwrite(uint8(U),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(FullGabungan).jpg'),'jpg');

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
                        disp('Angka yang Anda masukkan salah pada pemilihan warna');
                        break;
                    end
                    figure()
                    imshow(newii)

                    imwrite(uint8(newii),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(FullGabunganBedaWarna).jpg'),'jpg');


                    j = j + 1;
                end 
                i = i + 1;
            end
            elseif(modulus==0||modulus==1 && inputan ==1 )
            i = 1; 
            while i <= 1 
                j=1;
                while j <= 1
                    tic;
                    %figure;
					imgMirror_original = synthesize_texture(ukuran_new, height_after, width_after, 4);
                    
                    timerVal=toc;
                    x =imresize(imgMirror_original,[panjang_output lebar_output]);
                    imwrite(uint8(x),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(FullGabungan).jpg'),'jpg');
                      
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
                        disp('Angka yang Anda masukkan salah pada pemilihan warna');
                        break;
                    end
                    figure()
                    imshow(newii)
                    imwrite(uint8(newii),strcat(int2str(cek),'gambar generate dari- ',baseFileName,'(FullGabunganBedaWarna).jpg'),'jpg');

                    j = j + 1;
                end 
                i = i + 1;
            end 

        else
            disp('Inputan matrix sebaiknya lebih dari 0!');    
            break;
        end
    end
else
	disp('Masukan yang Anda buat salah.');
end
