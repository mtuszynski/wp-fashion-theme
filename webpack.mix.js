let mix = require('laravel-mix');

require('dotenv').config({path: '../../../../.env'});

const fs = require('fs');

function findFiles(dir) {
  return fs.readdirSync(dir).filter(file => {
    return fs.statSync(`${dir}/${file}`).isFile();
  });
}

function buildSass(dir, dest) {
  const regex = new RegExp('[^.scss]+$');
  findFiles(dir).forEach(function (file) {
    if (!file.startsWith('_') && !file.match(regex)) {
      mix.sass(dir + '/' + file, dest)
        .options({
          processCssUrls: false
        });
    }
  });
}

function buildJS(dir, dest) {
  const regex = new RegExp('[^.js]+$');
  findFiles(dir).forEach(function (file) {
    if (!file.match(regex)) {
      mix.js(dir + '/' + file, dest);
    }
  });
}

function buildTS(dir, dest) {
  const regex = new RegExp('[^.ts]+$');
  findFiles(dir).forEach(function (file) {
    if (!file.match(regex)) {
      mix.ts(dir + '/' + file, dest);
    }
  });
}

function buildMinify(dir, dest) {
  const regex = new RegExp('[^.' + dest + ']+$');
  findFiles(dir).forEach(function (file) {
    if (!file.endsWith('.min.' + dest) && !file.match(regex)) {
      mix.minify(dir + '/' + file);
    }
  });
}

buildSass('src/styles', 'css');

if (fs.existsSync('src/styles/blocks')) {
  buildSass('src/styles/blocks', 'public/css/blocks');
}

// buildJS('src/scripts/', 'js');
// if (fs.existsSync('src/scripts/blocks')) {
//   buildJS('src/scripts/blocks', 'public/js/blocks');
// }

buildTS('src/scripts/', 'public/js');
if (fs.existsSync('src/scripts/blocks')) {
  buildTS('src/scripts/blocks', 'public/js/blocks');
}

mix.setPublicPath('public');
mix.copy('src/images', 'public/images', false);

// mix.config.fileLoaderDirs.images = 'src/images';
// mix.config.fileLoaderDirs.fonts  = 'src/fonts';

mix.setResourceRoot('/wp-content/themes/invotech/');

if (Mix.inProduction()) {
  buildMinify('public/css', 'public/css')

  if (fs.existsSync('public/css/blocks')) {
    buildMinify('public/css/blocks', 'public/css')
  }

  buildMinify('public/js', 'public/js')

  if (fs.existsSync('public/js/blocks')) {
    buildMinify('public/js/blocks', 'public/js')
  }
}
