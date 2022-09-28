import React from "react";
import Home from "./components/Home";
import Navbar from "./components/Navbar/Navbar";

function App() {
    return (
        <div className="App">
            <div className="content">
                <React.Fragment>
                    <Navbar />
                </React.Fragment>
                <Home />
            </div>
        </div>
    );
}

export default App;
