module.exports = {
  // Output build
  dest: 'output/docs',

  title: 'PHP: Nelson Martell Library',
  description: 'A set of auxiliary classes for your PHP applications',

  markdown: {
    lineNumbers: true,
    toc: { includeLevel: [1, 2, 3] },
  },

  themeConfig: {
    // displayAllHeaders: true,

    nav: [
      { text: 'Guide', link: '/guide/' },
    ],

    sidebar: [
      {
        title: 'Guide',
        collapsable: false,
        children: [
          '/guide/',
          '/guide/install'
        ]
      },
    ],
    sidebarDepth: 3,

    lastUpdated: true,


    // Repo
    repo: 'nelson6e65/php_nml',
    docsDir: 'docs',
    editLinks: true,
    // editLinkText: 'Improve this page'
  }
}
