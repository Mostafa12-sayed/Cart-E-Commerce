export default {
  namespaced: true,
  state: {
    loading: false,
  },
  mutations: {
    showLoader(state) {
      state.loading = true;
    },
    hideLoader(state) {
      state.loading = false;
    },
  },
};
