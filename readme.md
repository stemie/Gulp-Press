#Gulp Press - starter theme using Gulp, Bower, Sass, Bourbon, Neat, _s

**There is a Gulp Task called `bower-_s` this should be removed after setup so that it's doesn't overwrite your theme files once you start working**

###You need to import bourbon and neat into the main style.scss
* `@import "bourbon/dist/bourbon";`
* `@import "neat/app/assets/stylesheets/neat";`

###If you want to start a new project based off this theme
* Clone it to your local machine with a new name `git clone https://stemie69@bitbucket.org/stemie69/gulp-press.git <new-theme-name>`
* Go to the new directory `cd <new-theme-name>`
* Push it to the new repo you created in bitbucket or the like `git push https://stemie69@bitbucket.org/stemie69/<new-theme-name>.git master:master`

###Don't forget to rename the _s theme (installed via bower automatically, lives in the the src folder)
* Search for: `'_s'` and replace with: `'mytheme'`
* Search for: `_s_` and replace with: `mytheme_`
* Search for: `Text Domain: _s` and replace with: `Text Domain: mytheme` in style.css.
* Search for: `_s` and replace with: ` Mytheme` **note there is a space before! ie. ' _s' => ' Megatherium'**
* Search for: `_s-` and replace with: `mytheme-`

###Dont forget to setup symlink (before running gulp) `$ mklink /j C:\repo\<theme-name>\build C:\wamp\www\<theme-name>\wp-content\themes\gulp-press`

###Credits
* [Gulp](http://gulpjs.com/), [Bower](http://bower.io/), and [Sass](http://sass-lang.com/). 
* This is largely based on https://github.com/synapticism/wordpress-gulp-bower-sass at the moment. For more information [check out this blog post](http://synapticism.com/wordpress-theme-development-with-gulp-bower-and-sass/).
* Using _s theme https://github.com/Automattic/_s
* The core `gulpfile.js` has been adapted from [Matt Banks](http://mattbanks.me/gulp-wordpress-development/). Additional credit is due to [Mark Goodyear](http://markgoodyear.com/2014/01/getting-started-with-gulp/).



## INSTALLATION

* Install Gulp and Bower with `npm install gulp -g` and `npm install bower -g`. Install Sass with `gem install sass`.
* Download or clone the repo and install all dependencies with `npm install` (which will run `bower install`). When you initialize your project npm will fetch the dependencies listed in `package.json`. You may wish to manually check for updates to these dependencies or use `npm update --save-dev` to bump version numbers in `package.json`.
* Edit `gulpfile.js` and change the `project` variable to match the name of your theme.



## ORGANIZATION

This starter kit is prepped to use three directories to manage theme development workflow from development through testing to production and release:

* `src`: this directory contains the raw material for your theme: templates, styles, scripts, and images. **Only edit files in this directory!**
* `build`: generated by Gulp, this is a working copy of your theme for use in development and testing. Symlink `build` to your `wp-content/themes` directory for local development and testing.
* `dist`: short for distribution, this will be the final, polished copy of your theme for production. You will need to manually run `gulp dist` to create a new distribution. You can also symlink this directory for a final round of testing; just keep in mind that your theme will now be in `dist/project`, where `project` is the variable you set in the Gulp file during installation. This project folder is what you will want to deploy to production.

Note: both the `build` and `dist` directories are disposable and can be regenerated from the materials in `src`.



## USAGE

### Bower

To install new front-end dependencies simply use `bower install [package] --save-dev`.

### Styles

* Sass files belong in `/src/scss`. Gulp will not process Sass partials beginning with `_`. These should be referenced by `style.scss` and any other stylesheet you would like to be generated and placed into `build`.
* The `build` folder is provisioned with regular and minified versions of all stylesheets but `dist` only contains minified versions for production.
* Bower components are in the path by default so you can `@import` Sass files directly, as seen in `_base_reset.scss`.
* This starter kit ships with [Normalize.css](https://necolas.github.io/normalize.css/) and [Eric Meyer's reset](http://meyerweb.com/eric/tools/css/reset/).
* Compass is not included as [Autoprefixer](https://github.com/ai/autoprefixer) eliminates the need for vendor prefixing (which is what most Sass frameworks focus on). If you're looking for a Sass mixin library for the post-vendor prefixing era try [Scut](https://davidtheclark.github.io/scut/).

### Scripts

JavaScript files should be kept in `src/js`.

Managing front-end scripts requires more manual configuration. For this you'll need to open up `gulpfile.js` and create a task representing an individual script bundle:

```
// An example task for extra scripts that aren't loaded on every page
gulp.task('scripts-extras', function() {
  return gulp.src([
    bower+'dependency/dependency.js'
  , source+'js/extras.js'
  ])
  .pipe(plugins.concat('extras.js'))
  .pipe(gulp.dest(build+'js/'));
});
```

In this example the `scripts-extras` task concatenates `dependency.js` and `extras.js` to create a new bundle that is then conditionally enqueued in WordPress. If you don't need more than one bundle you can always just add to the list of files used to generate `core.js`.

### Images

Images are simply copied from wherever they are in `src` to the same location under `build`. They are, however, optimized when you run `gulp dist`.

### PHP

Like images, PHP files can go anywhere under `src` and will be copied to `build` and `dist` while preserving directory structure.

### Other files

If you have other files you want to push through the asset pipeline you'll have to custom code another Gulp task.
