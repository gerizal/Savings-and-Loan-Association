const { defineConfig } = require("cypress");

module.exports = defineConfig({
  e2e: {
    baseUrl: 'http://sipkpfi.test',
    viewportWidth: 1280,
    viewportHeight: 720,
    
    // Preserve session between tests - don't clear cookies/storage
    testIsolation: false,

    // Video Recording Configuration
    video: true,
    videoCompression: 32,
    videosFolder: 'cypress/videos',
    videoUploadOnPasses: true,

    // Screenshot Configuration
    screenshotOnRunFailure: true,
    screenshotsFolder: 'cypress/screenshots',

    // Timeouts
    defaultCommandTimeout: 10000,
    pageLoadTimeout: 30000,
    requestTimeout: 10000,
    responseTimeout: 30000,

    // Reporter Configuration
    reporter: 'cypress-mochawesome-reporter',
    reporterOptions: {
      reportDir: 'cypress/reports',
      charts: true,
      reportPageTitle: 'SIPKPFI Automation Test Report',
      embeddedScreenshots: true,
      inlineAssets: true,
      saveAllAttempts: false,
      html: true,
      json: true,
      timestamp: 'yyyy-mm-dd_HH-MM-ss'
    },

    setupNodeEvents(on, config) {
      // implement node event listeners here
      require('cypress-mochawesome-reporter/plugin')(on);
      return config;
    },
  },
});
