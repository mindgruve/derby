#!/bin/sh

#################
#
# Install Image Utilities
#
#################

yum install -y perl-devel

# Install MozJPEG
yum install -y autoconf automake libtool nasm make
cd /tmp
wget https://github.com/mozilla/mozjpeg/archive/v3.1.zip
unzip v3.1.zip
cd mozjpeg-3.1/
autoreconf -fiv
mkdir build && cd build
sh ../configure
make install

# Install Gifsicle
cd /tmp
wget https://github.com/kohler/gifsicle/archive/master.zip
unzip master.zip
cd gifsicle-master/
autoreconf -i
./configure
make install

# Install Imagick
yum install -y ImageMagick ImageMagick-devel

# Install WebP
cd /tmp
wget http://downloads.webmproject.org/releases/webp/libwebp-0.4.3-rc1-linux-x86-64.tar.gz
tar -xvf libwebp-0.4.3-rc1-linux-x86-64.tar.gz
cd libwebp-0.4.3-rc1-linux-x86-64/bin
cp cwebp /usr/sbin
cp dwebp /usr/sbin
cp gif2webp /usr/sbin
cp vwebp /usr/sbin
cp webpmux /usr/sbin

# Install EXIF Tool
yum install -y perl-devel
cd /tmp
wget http://www.sno.phy.queensu.ca/~phil/exiftool/Image-ExifTool-10.01.tar.gz
tar -xvf Image-ExifTool-10.01.tar.gz
cd Image-ExifTool-10.01
perl Makefile.PL
make install
# Installed @ /usr/local/bin/exiftool