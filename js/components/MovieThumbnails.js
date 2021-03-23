export default {
    name: "TheMovieThumb",

    props: ['movie'],

    template: `
        <div>
            <h1>{{ movie.movies_title }}</h1>
        </div>
    `
}