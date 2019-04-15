/**
 * BLOCK: vms-models-dashboard
 *
 */

//  Import CSS.
import '../style/style.scss';
import '../style/editor.scss';


const { registerBlockType } = wp.blocks;
const { Component } = wp.element;
const { getCurrentPostId } = wp.data.select("core/editor");
const { TextControl, CheckboxControl } = wp.components;
const RichText = wp.editor.RichText;

registerBlockType( 'vms/vms-plugin-models-dashboard', {

	title: 'VMS - Models dashboard',
	icon: 'admin-users',
	category: 'widgets',
	edit: class extends Component {

	  constructor(props) {
	      super(...arguments);
	      this.props = props;
	  }

		handleChange = name => value => {
	    this.props.setAttributes({ [name]: value });
	  }

		handleSelectChange = name => event => {
		 var value = event.target.value;
		 this.props.setAttributes({ [name]: value });
	 }

	  render() {
	      const { className } = this.props;
				const {pages} = this.props.attributes;
				const selected = this.props.attributes.target_page;
	      var fieldsAttr = [
	        { placeholder: "Dashboard title", attr: "dashboard_title" },
					{ placeholder: "Model ID label", attr: "model_id_label"},
					{ placeholder: "Model title label", attr: "model_title_label"},
					{ placeholder: "Model category label", attr: "model_category_label"},
					{ placeholder: "Model category abbreviation label", attr: "model_category_abbreviation_label"},
					{ placeholder: "Model display label", attr: "model_display_label"},
					{ placeholder: "Add model button label", attr: "add_button_label"},
					{ placeholder: "Receipt download label", attr: "receipt_download_button_label"}
	      ];
				var saveDialogAttr = [
				  { placeholder: "Save button label", attr: "save_button_label" },
					{ placeholder: "Cancel button label", attr: "cancel_button_label" },
			  ];
	      return (
	        <div class="vms-form">
	          <h3><b>VMS - Models dashboard</b></h3>
	          <div>Model table</div>
	          {
	            fieldsAttr.map( (item, index) => {
	              return (
	                <TextControl type="text"
	                       placeholder={ item.placeholder }
	                       onChange={ this.handleChange(item.attr) }
	                       value={ this.props.attributes[item.attr] } />
	              )
	            })
	          }
						<hr/>
						<div>Texts</div>
						<RichText type="text"
									 		placeholder={ "Header text" }
									 		onChange={ this.handleChange("header_text") }
									 		value={ this.props.attributes["header_text"] } />
						<RichText type="text"
											placeholder={ "New receipt download needed" }
											onChange={ this.handleChange("receipt_download_text") }
											value={ this.props.attributes["receipt_download_text"] } />
						<RichText type="text"
									 		placeholder={ "No models text" }
									 		onChange={ this.handleChange("no_models_text") }
									 		value={ this.props.attributes["no_models_text"] } />
						<hr/>
						<div>Save/edit dialog</div>
						<RichText type="text"
											placeholder={ "Save/edit dialog header text" }
											onChange={ this.handleChange("dialog_header_text") }
											value={ this.props.attributes["dialog_header_text"] } />
						{
	            saveDialogAttr.map( (item, index) => {
	              return (
	                <TextControl type="text"
	                       placeholder={ item.placeholder }
	                       onChange={ this.handleChange(item.attr) }
	                       value={ this.props.attributes[item.attr] } />
	              )
	            })
	          }
						<hr/>
						<div>Delete dialog</div>
						<RichText type="text"
											placeholder={ "Delete dialog header text" }
											onChange={ this.handleChange("delete_header_text") }
											value={ this.props.attributes["delete_header_text"] } />
            <TextControl type="text"
                   placeholder={ "Delete button label" }
                   onChange={ this.handleChange("delete_button_label") }
                   value={ this.props.attributes["delete_button_label"] } />
						<hr/>
						<div>Errors</div>
	          <TextControl type="text"
	                  placeholder={ "Title missing error" }
	                  onChange={ this.handleChange("title_missing_error") }
	                  value={ this.props.attributes["title_missing_error"] } />
						<TextControl type="text"
	                  placeholder={ "Category missing error" }
	                  onChange={ this.handleChange("category_missing_error") }
	                  value={ this.props.attributes["category_missing_error"] } />
						<hr/>
						<div>Close contest</div>
				    <CheckboxControl
				        heading="Close"
				        checked={ this.props.attributes["subscription_closed"] }
				        onChange={ this.handleChange("subscription_closed")}
				    />
				</div>
			)
	  }
	},
	save: function(){
	  return null;
	}
});
