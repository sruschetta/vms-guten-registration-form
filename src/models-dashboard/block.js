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
const { TextControl } = wp.components;
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
	      ];
				var buttonsAttr = [
				 { placeholder: "Add button label", attr: "add_button_label" }
			 ];
	      return (
	        <div class="vms-form">
	          <h3><b>VMS - Models dashboard</b></h3>
	          <div>Placeholders</div>
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
						<RichText type="text"
									 		placeholder={ "No models text" }
									 		onChange={ this.handleChange("no_models_text") }
									 		value={ this.props.attributes["no_models_text"] } />
						<hr/>
					 	<div>Buttons</div>
	          {
	            buttonsAttr.map( (item, index) => {
	              return (
	                <TextControl type="text"
	                       placeholder={ item.placeholder }
	                       onChange={ this.handleChange(item.attr) }
	                       value={ this.props.attributes[item.attr] } />
	              )
	            })
	          }
				</div>
			)
	  }
	},
	save: function(){
	  return null;
	}
});
