/**
 * BLOCK: mango-blocks
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
// import './editor.scss';
import './style.scss';

const { __ } = wp.i18n; // Import __() from wp.i18n
// import _ from lodash;
import classNames from "classnames";
const { createHigherOrderComponent } = wp.compose;
const { addFilter } = wp.hooks;
const { Fragment } = wp.element;
const { InspectorControls } = wp.editor;
import { filterControlOptions } from "./filters"
const { 
	PanelBody,
	RangeControl
 } = wp.components;

const { 
	SelectControl,
	FormToggle
 } = wp.components;

// Available Filters

/*
 * Add new attribute to the block.
 */
function addAttributes(settings, name) {
	if (name !== "core/image") {
		return settings;
	}
	if (typeof settings.attributes !== "undefined") {
		settings.attributes = lodash.assign(settings.attributes, {
			filter: {
				type: "string",
				default: "test"
			},
			hasCustomFilter: {
				type: "boolean",
				default: false
			},
			filterBlur: {
				type: "number",
				default: 0
			},
			
		});

		 
	}
	 
	return settings;
}

addFilter (
	"blocks.registerBlockType",
	"custom-image-filter/attributes",
	addAttributes
);

/*
 * Add controls to block inspector.
 */
const withInspectorControls = createHigherOrderComponent(BlockEdit => {
	return props => {

		// return with wrong block
		if (props.name !== "core/image") {
			return <BlockEdit {...props} />;
		}
		const { 
			filter,
		} = props.attributes;
		
		return (
			<Fragment>
				<div className={filter}>
					<BlockEdit {...props} />
				</div>
				<InspectorControls>
					<PanelBody title={__("Image Filter")}>
						 
						<SelectControl
							label={__("Filter")}
							value={filter}
							options={filterControlOptions}
							onChange={ selectedFilter => {
								props.setAttributes({
									filter: selectedFilter,
								});
							}}
						/>
					
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, "withInspectorControls");

addFilter(
	"editor.BlockEdit",
	"custom-image-filter/controls",
	withInspectorControls
);

/* After save filter */

const applyExtraClass = (saveElementProps, blockType, attributes) => {
	// Do nothing if it's another block than our defined ones.
	
	if (blockType.name !== "core/image") {
		return saveElementProps;
	}
	// const { filter } = attributes;
	// saveElementProps.className = classNames(
	// 	filter
	// );
 	
	return saveElementProps;
};

addFilter(
	'blocks.getSaveContent.extraProps',
	'custom-image-filter/apply-class',
	applyExtraClass
);


 