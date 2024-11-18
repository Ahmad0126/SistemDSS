import { Head } from "@inertiajs/react";

export default function Home(props){
    console.log(props);
    return (
        <>
            <Head title={props.title} />
            <h1>Hello World</h1>
        </>
    )
}