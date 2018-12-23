module.exports = {
  // Output build
  dest: 'output/docs',
  base: '/php_nml/',

  title: 'PHP: Nelson Martell Library',
  description: 'A set of auxiliary classes for your PHP applications',

  markdown: {
    lineNumbers: false,
    toc: { includeLevel: [1, 2, 3] },
  },

  themeConfig: {
    // displayAllHeaders: true,

    nav: [
      { text: 'Guide', link: '/guide/' },
      { text: 'API', link: '/api/' },
    ],

    sidebar: {
      '/guide/': [
        {
          title: 'Guide',
          collapsable: false,
          children: [
            '',
            'install',
          ]
        }
      ],
      '/api/': [
        {
          title: 'API',
          collapsable: false,
          children: [
            '',
            'classes',
            'interfaces',
            'traits',
            'functions',
            'constants'
          ]
        }
      ],
      '/': [
        ''
      ]
    },
    sidebarDepth: 3,

    lastUpdated: true,


    // Repo
    repo: 'nelson6e65/php_nml',
    docsDir: 'docs',
    editLinks: true,
    // editLinkText: 'Improve this page'
  }
}
