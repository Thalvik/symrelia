export class App {
  configureRouter(config, router) {
    config.title = 'Aurelia';
    config.map([
      { route: ['', 'articles'],name: 'articles',moduleId: 'articles', nav: false, title: 'Articles' }
    ]);

    this.router = router;
  }

  
}
