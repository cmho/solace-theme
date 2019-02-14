// import external dependencies
import 'jquery';
import 'datatables.net-dt';
import 'jquery-accessible-modal-window-aria';
import 'trumbowyg';

// Import everything from autoload
import "./autoload/**/*"

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';
import templateCharacterList from './routes/characterList';
import templateDashboard from './routes/dashboard';
import singleCharacter from './routes/character';

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
  templateDashboard,
  templateCharacterList,
  singleCharacter,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
