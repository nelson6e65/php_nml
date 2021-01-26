module.exports = {
  // Output build
  dest: 'output/docs/php_nml',
  // base: '/php_nml/', // Only necesary for GitHub Pages

  title: 'PHP: Nelson Martell Library',
  description: 'A set of auxiliary classes for your PHP applications',

  plugins: {
    '@vuepress/google-analytics': {
      ga: 'UA-58599811-1',
    },
    // 'vuepress-plugin-clean-urls': {},
  },

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
          children: ['', 'install'],
        },
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
            'constants',
          ],
        },
      ],
      '/': [''],
    },
    sidebarDepth: 3,

    lastUpdated: true,

    // Repo
    repo: 'nelson6e65/php_nml',
    docsDir: 'docs',
    editLinks: true,
    // editLinkText: 'Improve this page'
  },

  configureWebpack: {
    output: {
      filename: '[name].js',
      chunkFilename: 'assets/js/[name].js' + '?id=[chunkhash]',
    },
  },
};
