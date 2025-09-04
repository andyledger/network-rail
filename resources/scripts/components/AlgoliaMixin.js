import algoliasearch from 'algoliasearch/lite';
// import axios from 'axios';

export default {
  name: 'algolia-mixin',

  data() {
    return {
      applicationID: 'UWXBMB9OS2',
      searchApiKey: 'd22695cebc9a021e07f3c4d9c828c1e4',
      indexName: 'production_index_all',
    }
  },

  computed: {
    searchClient() {
      return algoliasearch(
        this.applicationID,
        this.searchApiKey
      )
    }
  },

  // beforeCreate() {
  //   axios.get('/wp-json/options/v1/algolia_public_data')
  //     .then((response) => {
  //       this.applicationID = response.data.algolia_applicationID;
  //       this.searchApiKey = response.data.algolia_searchApiKey;
  //       this.indexName = response.data.algolia_indexName;
  //     })
  // }
}
