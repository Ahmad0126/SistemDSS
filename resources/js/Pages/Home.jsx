import { Head } from "@inertiajs/react";
import Sidebar from "./Components/Sidebar";
import Navbar from "./Components/Navbar";

export default function Home(props){
    console.log(props);
    return (
        <>
            <Head title={props.title} />
            <div className="wrapper">
                <Sidebar/>
                <div className="main-panel">
                    <Navbar/>
                    <div className="container">
                        <div className="page-inner">
                            <h1>Hello World</h1>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}