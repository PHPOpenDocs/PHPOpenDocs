import {h, Component} from "preact";


let api_urls = {
    production: 'https://bugs.php.net',
    development: 'http://127.0.0.1:8080'
};

// check environment mode
let environment = process.env.NODE_ENV === 'production' ? 'production' : 'development';

// @ts-ignore:int blah blah
let api_url: string = api_urls[environment];

export interface CommentsPanelProps {
    // api_url: string;
    // initialControlParams: object;
}

interface Comment {
    comment_id: number;
    bug_id: number;
    error: string|null;
    email: string|null;
}

interface CommentsPanelState {
    max_comment_id: number|null;
    comments: Array<Comment>
}

function getDefaultState(/*initialControlParams: object*/): CommentsPanelState {
    return {
        max_comment_id: null,
        comments: []
    };
}

// http://127.0.0.1/api.php?type=comment_details&comment_id=1
// {"comment_id":1,"error":"bug report is private", "bug_id": 3}
// {"comment_id":1,"email":"asda.. at bar dot com", "bug_id": 3}
// http://127.0.0.1/api.php?type=max_comment_id
// {"max_comment_id":1}

export class CommentsPanel extends Component<CommentsPanelProps, CommentsPanelState> {

    // timeout:number = 250; // Initial timeout duration as a class variable

    // How often to check for new comments in seconds
    refresh_rate:number = 10;

    // Store the callback so it can be cancelled on manual refresh
    fetchMaxCommentCallback:NodeJS.Timeout = null;
    // TODO - clearTimeout(this.connectInterval);

    restoreStateFn: Function;

    maxCommentId: number|null = null;
    maxLoadedCommentId: number|null = null;

    constructor(props: CommentsPanelProps) {
        super(props);
        this.state = getDefaultState(/*props.initialControlParams*/);
        this.fetchMaxCommentData();
    }

    processMaxCommentData(data: any) {
        if (data.max_comment_id == undefined) {
            console.log("Data did not return max_comment_id");
            return;
        }
        // @ts-ignore:int blah blah
        this.setState({max_comment_id: data.max_comment_id});
        this.maxCommentId = data.max_comment_id;
        this.fetchComments();
    }

    fetchComments() {
        // this is the first comment loaded, so just load it
        if (this.maxLoadedCommentId == null) {
            this.fetchComment(this.maxCommentId);
            this.maxLoadedCommentId = this.maxCommentId;
            return;
        }

        for (let i=this.maxLoadedCommentId; i<this.maxCommentId; i+=1) {
            this.fetchComment(i);
        }

        this.maxLoadedCommentId = this.maxCommentId;
    }

    fetchComment(commentId: number) {
        console.log("Need to load comment " + commentId);

        let url = api_url + '/api.php?type=comment_details&comment_id=' + commentId;

        fetch(url)
            .then(response => response.json())
            .then(data => this.processCommentData(commentId, data))
            .catch(function(error) {                        // catch
                console.log('Request failed', error);
            });
    }

    processCommentData(commentId: number, data: any) {
        console.log(commentId);
        console.log(data);

        let comment:Comment = {
            comment_id: data.comment_id,
            bug_id: data.bug_id,
            error: data.error ?? null,
            email: data.email ?? null,
        };

        let newComments: Array<Comment> = this.state.comments;
        newComments.unshift(comment);
        newComments = newComments.slice(0, 10);

        this.setState({comments: newComments});
    }

    fetchMaxCommentData() {
        let url = api_url + '/api.php?type=max_comment_id';
        fetch(url)
            .then(response => response.json())
            .then(data => this.processMaxCommentData(data))
            .catch(function(error) {                        // catch
                console.log('Request failed', error);
            });


        //call check function after timeout
        // @ts-ignore: Timeout blah blah
        this.fetchMaxCommentCallback = setTimeout(
            () => this.fetchMaxCommentData(),
            this.refresh_rate * 1000
        );
        console.log("Should refresh");
    }

    componentDidMount() {
        this.restoreStateFn = (event:any) => this.restoreState(event.state);
        // @ts-ignore: I don't understand that error message.
        window.addEventListener('popstate', this.restoreStateFn);
    }

    componentWillUnmount() {
        // unbind the listener
        // @ts-ignore: I don't understand that error message.
        window.removeEventListener('popstate', this.restoreStateFn, false);
        this.restoreStateFn = null;
    }

    restoreState(state_to_restore: object) {
        // if (state_to_restore === null) {
        //     this.setState(getDefaultState(this.props.initialControlParams));
        //     return;
        // }
        //
        // this.setState(state_to_restore);
        // this.triggerSetImageParams();
    }

     renderComment(comment: Comment, index: number) {
         let url = 'http://127.0.0.1:8080/bug.php?id=' + comment.bug_id
         if (comment.email != null) {
             return <div key={index}>
             Comment {comment.comment_id} from {comment.email} for <a href={url} target="_blank">bug {comment.bug_id}</a>

            </div>;
         }

         return <div key={index}>
             {comment.comment_id} hidden as {comment.error} <a href={url} target="_blank">bug {comment.bug_id}</a>
         </div>;
    }

    renderComments() {
        if (this.state.comments.length == 0) {
            return <span>No comments</span>
        }

        return <div>
            {this.state.comments.map(this.renderComment)}
        </div>;
    }

    render(props: CommentsPanelProps, state: CommentsPanelState) {
        let comments_block = this.renderComments();
        return  <div class='comments_panel_react'>
            <span>
                {comments_block}
            </span>
        </div>;
    }
}










