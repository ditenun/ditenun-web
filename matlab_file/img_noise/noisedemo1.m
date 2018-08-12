% Get list of all files in this directory
diary('Data\output.txt');
diary on;
imagefiles1 = dir('EDataBad\*.jpg');       %  all file names in directory, give your extension
imagefiles2 = dir('EDataGood\*.jpg');     
imagefiles3 = dir('EDataImprove\*.jpg');
imagefiles4 = dir('Data\*.jpg');
nfiles1 = length(imagefiles1);     % total number of files found
nfiles2 = length(imagefiles2);
nfiles3 = length(imagefiles3);
nfiles4 = length(imagefiles4);
% for ii=1:nfiles1  % loop for each file 
%    currentfilename = imagefiles1(ii).name;  
%    currentimage = double(imread(['EDataBad\' currentfilename]));
%    nlevel{ii} = NoiseLevel(currentimage);
%      fprintf(currentfilename+" ");
%      fprintf(' : %f ',nlevel{ii});
%      fprintf('\n');
% end
% diary off;

% diary('EDataGood\output.txt');
% diary on;
% for ii=1:nfiles2  % loop for each file 
%    currentfilename = imagefiles2(ii).name;  
%    currentimage = double(imread(['EDataGood\' currentfilename]));
%    nlevel{ii} = NoiseLevel(currentimage);
%      fprintf(currentfilename+" ");
%      fprintf(' : %f ',nlevel{ii});
%      fprintf('\n');
% end
% diary off;

% diary('EDataImprove\output.txt');
% diary on;
% for ii=1:nfiles3  % loop for each file 
%    currentfilename = imagefiles3(ii).name;  
%    currentimage = double(imread(['EDataImprove\' currentfilename]));
%    nlevel{ii} = NoiseLevel(currentimage);
%      fprintf(currentfilename+" ");
%      fprintf(' : %f ',nlevel{ii});
%      fprintf('\n');
% end
% diary off;

diary('Data\output.txt');
diary on;
for ii=1:nfiles1  % loop for each file 
   currentfilename = imagefiles1(ii).name;  
   currentimage = double(imread(['EDataBad\' currentfilename]));
   nlevel{ii} = NoiseLevel(currentimage);
     fprintf(currentfilename+" ");
     fprintf(' : %f ',nlevel{ii});
     fprintf('\n');
end
diary off;

