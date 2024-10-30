import './editor.scss';
import './style.scss';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { SelectControl } = wp.components;
const {
	BlockControls,
	AlignmentToolbar,
} = wp.editor;
const { withSelect } = wp.data;

registerBlockType( 'block-views/post-meta', {

	title: __( 'Post Meta' ),
	icon: 'admin-generic',
	category: 'common',
	// parent: ['block-views/post-view'], // Maybe can't set, because want to double-nest inside of columns.
	keywords: [
		__( 'Post' ),
		__( 'Meta' ),
	],

    attributes: {
        postmeta: {
            type: 'string',
		},
		alignment: {
			type: 'string',
		},
		usermeta: {
			type: 'string',
		},
	},

	edit: ( props ) => {

		let preview;
		// @TODO: Extract to seperate files.
		switch(props.attributes.postmeta) {
			case 'post_title': preview = <h3>Lorem Ipsum</h3>; break;
			case 'post_author': 
				let usermeta;
				switch(props.attributes.usermeta) {
					case 'user_login': usermeta = 'author'; break;
					case 'user_nicename': usermeta = 'Author'; break;
					case 'display_name': usermeta = 'Author Name'; break;
					case 'first_name': usermeta = 'First Name'; break;
					case 'last_name': usermeta = 'Last Name'; break;
					case 'user_email': usermeta = 'author@site.com'; break;
					default:
						usermeta = 'Post Author'
				}
				preview = <div>{usermeta}</div>;
				break;
			case 'post_content': preview = <p>
				Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur purus nisl, faucibus ac mauris sed, vulputate molestie nulla. Phasellus nec congue nunc, ac cursus tellus. Praesent eu sagittis enim, pretium ultrices nulla. Aliquam vel hendrerit nibh. Donec iaculis elit lectus, ut convallis libero tempor vitae. Donec scelerisque posuere risus lacinia aliquam.
			</p>; break;
			default: preview = <div></div>
		}

        return [
			props.isSelected && (
				<BlockControls>
					<AlignmentToolbar
						value={ props.attributes.alignment }
						onChange={ (newAlignment) => {props.setAttributes( {alignment: newAlignment} )}}
					/>
				</BlockControls>
			),
			!props.attributes.postmeta && (<SelectControl
				value={ props.attributes.postmeta }
				onChange={ ( newPostmeta ) => { props.setAttributes( { postmeta: newPostmeta } ) } }
				options={ [
					{ value: null, label: 'Select postmeta', disabled: true },
					{ value: 'post_title', label: 'Title' },
					{ value: 'post_content', label: 'Content' },
					{ value: 'post_author', label: 'Author' },
				] }
			/>),
			props.attributes.postmeta && ( <div
				style={ { textAlign: props.attributes.alignment } }
				>
				{preview}
			</div> ),
			props.isSelected && 'post_author' === props.attributes.postmeta && (<SelectControl
				value={ props.attributes.usermeta }
				onChange={ ( newUsermeta ) => { props.setAttributes( { usermeta: newUsermeta } ) } }
				options={ [
					{ value: null, label: 'Select usermeta', disabled: true },
					{ value: 'user_login', label: 'User Login' },
					{ value: 'user_nicename', label: 'Nice Name' },
					{ value: 'display_name', label: 'Display Name' },
					{ value: 'first_name', label: 'First Name' },
					{ value: 'last_name', label: 'Last Name' },
					{ value: 'user_email', label: 'Email' },
				] }
			/>),
		]
	},

	save: ( props ) => {
		// Server Side Rendering
	},
} );
