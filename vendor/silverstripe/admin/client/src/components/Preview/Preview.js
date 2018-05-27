import React, { Component } from 'react';
import i18n from 'i18n';
import PopoverField from 'components/PopoverField/PopoverField';

/**
 * Renders the right-hand collapsable change preview panel
 */
class Preview extends Component {
  constructor(props) {
    super(props);

    this.handleBackClick = this.handleBackClick.bind(this);
  }

  handleBackClick(event) {
    if (typeof this.props.onBack === 'function') {
      event.preventDefault();
      this.props.onBack(event);
    }
  }

  render() {
    let body = null;
    let previewUrl = null;
    let previewType = '';

    // Find preview url
    if (this.props.itemLinks && this.props.itemLinks.preview) {
      if (this.props.itemLinks.preview.Stage) {
        previewUrl = this.props.itemLinks.preview.Stage.href;
        previewType = this.props.itemLinks.preview.Stage.type;
      } else if (this.props.itemLinks.preview.Live) {
        previewUrl = this.props.itemLinks.preview.Live.href;
        previewType = this.props.itemLinks.preview.Live.type;
      }
    }

    // Build actions
    let editUrl = null;
    const editKey = 'edit';
    const toolbarButtons = [];
    if (this.props.itemLinks && this.props.itemLinks.edit) {
      editUrl = this.props.itemLinks.edit.href;
      toolbarButtons.push(
        <a key={editKey} href={editUrl} className="btn btn-outline-secondary font-icon-edit">
          <span className="btn__title">{ i18n._t('Admin.EDIT', 'Edit') }</span>
        </a>
      );
    }

    // Build body
    if (!this.props.itemId) {
      body = (
        <div className="preview__overlay">
          <h3 className="preview__overlay-text">No preview available.</h3>
        </div>
      );
    } else if (!previewUrl) {
      body = (
        <div className="preview__overlay">
          <h3 className="preview__overlay-text">There is no preview available for this item.</h3>
        </div>
      );
    } else if (previewType && previewType.indexOf('image/') === 0) {
      body = (
        <div className="preview__file-container panel--scrollable">
          <img alt={previewUrl} className="preview__file--fits-space" src={previewUrl} />
        </div>
      );
    } else {
      body = <iframe className="flexbox-area-grow preview__iframe" src={previewUrl} />;
    }

    const backButton = (typeof this.props.onBack === 'function') && (
      <button
        className="btn btn-secondary font-icon-left-open-big toolbar__back-button hidden-lg-up"
        type="button"
        onClick={this.handleBackClick}
      >Back</button>
    );

    const moreActions = this.props.moreActions && this.props.moreActions.length > 0
      ? (
        <PopoverField data={{ placement: 'top' }} id="campaign-preview-popver">
          {this.props.moreActions}
        </PopoverField>
      )
      : null;

    // Combine elements
    return (
      <div className="flexbox-area-grow fill-height preview campaign-admin__campaign-preview">
        {body}
        <div className="toolbar toolbar--south">
          { backButton }
          <div className="btn-toolbar">
            {toolbarButtons}
            {moreActions}
          </div>
        </div>
      </div>
    );
  }
}

Preview.propTypes = {
  itemLinks: React.PropTypes.object,
  itemId: React.PropTypes.number,
  onBack: React.PropTypes.func,
  moreActions: React.PropTypes.arrayOf(React.PropTypes.element),
};

export default Preview;
