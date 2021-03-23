import MovieThumbnails from './components/MovieThumbnails.js';

(() => {
    const myVM = new Vue({
        data: {
            movies: []
        },

        created: function () {
            fetch('./index.php')
                .then(res => res.json())
                .then(data => this.movies = data)
                .catch(err => console.log(err));

            console.log("Hello!");
        },

        methods: {

        },

        components: {
            moviethumb: MovieThumbnails
        }
    }).$mount("#app");
})();