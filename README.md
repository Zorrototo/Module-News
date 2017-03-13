# Module-News
Simple news module for OGP

Based on News Lister from www.netartmedia.net/

**Removed unused features:**
- google maps
- contact form
- settings edition page
- login

**To Do List**
- clean the CSSs...
- remove all unused files
- remove all parts of code related to pretty URLs (SEO blabla), google maps, and so on..
- have localization done like other modules in OGP
- have image deletion actually work and remove images from server when deleting article or modifying images
- disallow having empty fields server side when adding/editing article
- ...

**Install Requirement and Other**
- Place the "news" folder inside OGP Panel "modules" folder, then install module from Administration->Modules
- NO database required, news are stored in XML files
- Following folders/file need to have write access: "data", "data/listings.xml", "thumbnails", "uploads", and "uploaded_images"
- May be dangerous to use on production server because of possible security issues, and other bugs
- ...
