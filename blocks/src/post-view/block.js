import './editor.scss';
import './style.scss';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const {
	ServerSideRender,
	TextControl,
	ToggleControl,
} = wp.components;
const {
	InnerBlocks,
	InspectorControls,
} = wp.editor;

registerBlockType( 'block-views/post-view', {
	title: __( 'Post View' ),
	icon: 'list-view',
	category: 'common',
	supports: {
		align: [ 'wide' ],
	},
	keywords: [
		__( 'Post' ),
		__( 'View' ),
	],

    attributes: {
        postsPerPage: {
			type: 'integer',
		},
	},

	edit: ( props ) => {

		const TEMPLATE = [
			['block-views/post-meta', {}, []],
		]

		// TODO: Doesn't track in nested blocks, ie can add anything to a column inside of the view block.
		const ALLOWED_BLOCKS = [
			'block-views/post-meta',
			'core/columns',
			'core/spacer',
			'core/seperator',
			'core/more',
		];

		return [
			props.isSelected && (
				<InspectorControls>
					<TextControl
						type="number"
						min="-1"
						label={__( 'Posts Per Page')}
						value={ props.attributes.postsPerPage }
						onChange={ ( newPostsPerPage ) => props.setAttributes( { postsPerPage: newPostsPerPage } ) }
					/>
				</InspectorControls>
			),
			<div className={ props.className }>
				<InnerBlocks
					template={ TEMPLATE }
					allowedBlocks={ ALLOWED_BLOCKS }
				/>
			</div>
		];

		return (
            <ServerSideRender
                block="block-views/post-view"
                attributes={ props.attributes }
            />
		);
	},

	save: ( props ) => {
		return (
			<div>
				<InnerBlocks.Content />
			</div>
		);
	},
} );
