import MovieThumb from './components/MovieThumbnails.js';

(() => {
    const myVM = new Vue({
        data: {
            movies: [],
            filteredMovies:[]
        },

        created: function () {
            fetch('./index.php')
                .then(res => res.json())
                .then(data => this.movies = this.filteredMovies = data)
                .catch(err => console.log(err));
        },

        methods: {
               filterMovies(genre){
                   if(genre == 'all') {
                       this.filteredMovies = this.movies;
                       return;
                    }

                   this.filteredMovies = this.movies.filter(movie => movie.genre_name.toLowerCase().includes(genre));
                // debugger;
               }
        },

        components: {
            moviethumb: MovieThumb
        }
    }).$mount("#app");
})();