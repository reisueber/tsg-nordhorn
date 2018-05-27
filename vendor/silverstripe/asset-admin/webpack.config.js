const Path = require('path');
const webpackConfig = require('@silverstripe/webpack-config');
const {
  resolveJS,
  externalJS,
  moduleJS,
  pluginJS,
  moduleCSS,
  pluginCSS,
} = webpackConfig;

const ENV = process.env.NODE_ENV;
const PATHS = {
  MODULES: 'node_modules',
  FILES_PATH: '../',
  ROOT: Path.resolve(),
  SRC: Path.resolve('client/src'),
  DIST: Path.resolve('client/dist'),
  LEGACY_SRC: Path.resolve('client/src/entwine'),
};

const config = [
  {
    name: 'js',
    entry: {
      bundle: `${PATHS.SRC}/bundles/bundle.js`,
      TinyMCE_ssmedia: `${PATHS.LEGACY_SRC}/TinyMCE_ssmedia.js`,
      TinyMCE_ssembed: `${PATHS.LEGACY_SRC}/TinyMCE_ssembed.js`,
      'TinyMCE_sslink-file': `${PATHS.LEGACY_SRC}/TinyMCE_sslink-file.js`,
    },
    output: {
      path: PATHS.DIST,
      filename: 'js/[name].js',
    },
    devtool: (ENV !== 'production') ? 'source-map' : '',
    resolve: resolveJS(ENV, PATHS),
    externals: Object.assign(
      {},
      externalJS(ENV, PATHS),
      {
        // @todo remove this once @silverstripe/webpack-config has this updated and published
        'containers/InsertLinkModal/fileSchemaModalHandler': 'FileSchemaModalHandler',
        'state/unsavedForms/UnsavedFormsActions': 'UnsavedFormsActions',
        'components/PopoverField/PopoverField': 'PopoverField',
      }
    ),
    module: moduleJS(ENV, PATHS),
    plugins: pluginJS(ENV, PATHS),
  },
  {
    name: 'css',
    entry: {
      bundle: `${PATHS.SRC}/styles/bundle.scss`,
    },
    output: {
      path: PATHS.DIST,
      filename: 'styles/[name].css',
    },
    devtool: (ENV !== 'production') ? 'source-map' : '',
    module: moduleCSS(ENV, PATHS),
    plugins: pluginCSS(ENV, PATHS),
  },
];

// Use WEBPACK_CHILD=js or WEBPACK_CHILD=css env var to run a single config
module.exports = (process.env.WEBPACK_CHILD)
  ? config.find((entry) => entry.name === process.env.WEBPACK_CHILD)
  : module.exports = config;
