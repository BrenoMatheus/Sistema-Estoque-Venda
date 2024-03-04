module.exports = {
  devServer: {
    allowedHosts: 'all',
    proxy: {
      '^/api': {
        target: 'https://touching-noted-firefly.ngrok-free.app/',
        ws: true,
        changeOrigin: true,
      },
    },
  },
};
