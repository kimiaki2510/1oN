import React from 'react';
import ReactDOM from 'react-dom';

const App: React.FC = () => {
    return (
        <h1>Hello Tom</h1>
    )
}

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}