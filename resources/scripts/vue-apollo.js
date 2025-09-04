import { ApolloClient } from 'apollo-client';
import { createHttpLink } from 'apollo-link-http';
import { InMemoryCache } from 'apollo-cache-inmemory';
import Vue from 'vue';
import VueApollo from 'vue-apollo';
import { setContext } from 'apollo-link-context';

const key = '10159536aaeb4647b8fd2a2aae2de158';

const getAuthToken = async () => {
  const myHeaders = new Headers({
    'Content-Type': 'application/json',
    'x-lne-api-key': key,
  });

  const response = await fetch(
    'https://nr-lift-and-escalator.azure-api.net/auth/token/',
    {
      method: 'POST',
      headers: myHeaders,
    }
  );

  const data = await response.json();
  console.log('Token received: ', data);

  return `Bearer ${data.access_token}`;
};

// HTTP connection to the API
const httpEndpoint = 'https://nr-lift-and-escalator.azure-api.net/graphql/v2';

const httpLink = createHttpLink({
  uri: httpEndpoint,
});

const authLink = setContext(async (_, { headers }) => {
  const token = await getAuthToken();
  return {
    headers: {
      ...headers,
      authorization: token,
    },
  };
});

// Create the apollo client
const apolloClient = new ApolloClient({
  httpEndpoint,
  ssr: false,
  link: authLink.concat(httpLink),
  cache: new InMemoryCache(),
  connectToDevTools: true,
});

// Install the vue plugin
Vue.use(VueApollo);

const apolloProvider = new VueApollo({
  defaultClient: apolloClient,
});

export default apolloProvider;
