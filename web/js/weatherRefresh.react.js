var NoteSection = React.createClass({
    getInitialState: function () {
        console.log('initial state');
        return {
            notes: []
        }
    },
    componentDidMount: function () {
        this.loadNotesFromServer();
        setInterval(this.loadNotesFromServer, 200000000);
    },
    loadNotesFromServer: function () {
        $.ajax({
            type: "GET",
            url: this.props.url,
            success: function (data) {
                this.setState({notes: data.notes});
            }.bind(this)

        });
    },
    render: function () {
        return (
            <div>
                <NoteList notes={this.state.notes}/>
            </div>
        );
    }
});

var NoteList = React.createClass({
    render: function () {
        var noteNodes = this.props.notes.map(function (note) {
            return (
                <div>
                    <div >
                        <h2>{note.city}</h2>
                        <p>{note.temp}, {note.cond}</p>
                    </div>
                </div>
            );
        });
        return (
            <section>
                {noteNodes}
            </section>
        );
    }
});


window.NoteSection = NoteSection;