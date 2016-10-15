<?php
$sourceDir = $argv[1];
$destDir = $argv[2];


if(! is_dir($destDir) && ! is_writable($destDir))
{
  echo "\n Invalid dest dir";
}

$stranges = glob($destDir.'/jpg/-*.jpg');
foreach($stranges as $strange)
{
  $strangeCorrected = str_replace('-', '', $strange);
  rename($strange, $strangeCorrected);
}


$sourcesFiles = glob($sourceDir.'/recup*/*');
foreach($sourcesFiles as $sourceFile)
{
  //var_dump($sourceFile);
  $ext = pathinfo($sourceFile, PATHINFO_EXTENSION);
  $ext = strtolower($ext);
  if(empty($ext))
  {
    continue;
  }
  $fileDestDir = $destDir.'/'.$ext.'/';
  if( ! file_exists($fileDestDir))
  {
    mkdir($fileDestDir);
  }
  $newFileName = $fileDestDir.basename($sourceFile);
  $i=2;
  while(file_exists($newFileName))
  {
    $newFileName = $fileDestDir.$i.'-'.basename($sourceFile);
    $i++;
  }
  //echo "\n\t".$sourceFile.'->'.$newFileName."\n";
  rename($sourceFile, $newFileName);
  
  if($ext == 'jpg')
  {
    $cmd = "exiv2 -F rename ".escapeshellarg($newFileName);
    passthru($cmd);
  }
  echo ".";
  //sleep(10);
}

echo "\nFIN\n";
//mv 2000*.jpg 2000/ ; mv 2001*.jpg 2001/ ; mv 2002*.jpg 2002/ ; mv 2003*.jpg 2003/ ; mv 2004*.jpg 2004/ ; mv 2005*.jpg 2005/ ; mv 2006*.jpg 2006/ ; mv 2007*.jpg 2007/ ; mv 2008*.jpg 2008/ ; mv 2009*.jpg 2009/ ; mv 2010*.jpg 2010/ ; mv 2011*.jpg 2011/ ; mv 2012*.jpg 2012/ ; mv 2013*.jpg 2013/ ; mv 2014*.jpg 2014/ ; mv 2015*.jpg 2015/ ; mv 2016*.jpg 2016/