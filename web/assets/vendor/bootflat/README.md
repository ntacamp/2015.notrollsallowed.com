# NTACamp page html layout
## How to develop

### Tools you will need

**Node.js**

How to install Node.js check official [wiki](https://github.com/joyent/node/wiki/Installing-Node.js-via-package-manager).

**Grunt**

    npm install grunt-cli -g

**Compass**

    gem install compass



### Development

If you just cloned repository, or `package.json` has been changed, run:

    npm install

Then use
    
    # Perform all tasks
    grunt

    # Generate SASS to CSS
    grunt sass:dist 

    # Watch for HTML and SCSS file changes, auto-generates CSS, reloads(*) page
    grunt watch

* `grunt watch` will reload page if your HTML file contains JavaScript `<script src="//localhost:35729/livereload.js"></script>`

## Where is what?
### home.html
1. Header
2. Footer
3. Homepage content blocks

### page.html
1. Sidebar
    - Blog feed
    - #ntacamp feed
    - Sponsors
2. Simple page content block

### registration.html
1. Registration form

### schedule.html
1. Still work in progress, do not use.

## TODO

- Homepage: Slider
    1. Prepare images for slider. Crop in proper composition.
    2. Add overlay on top of slider images with repeated background image 'bootflat/img/bg-dots.png'.
- Homepage: Where?
    1. Needs awesome icon instead of plain tree.
- Homepage: When?
    1. Needs awesome illustration
- Homepage: Organizeres
    1. Needs awesome illustration
- Page: #ntacamp feed
    1. Better styling for text and image content
- Page: BLOG feed
    1. Better styling for text and image content
- FAQ
    ~~1. Page layout~~ DONE.
- Contact
    ~~1. Page layout~~ DONE.
- Location
    1. Page layout with nicely integrated google map
- Schedule
    1. Page layout
