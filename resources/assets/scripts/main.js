// import external dependencies
import 'jquery';
import 'datatables.net-dt';
import 'jquery-accessible-modal-window-aria';

// Import everything from autoload
import "./autoload/**/*"

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';
import characterList from './routes/characterList';

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
  characterList,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
