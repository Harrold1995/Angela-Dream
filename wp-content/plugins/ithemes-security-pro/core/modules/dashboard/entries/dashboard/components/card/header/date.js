/**
 * External dependencies
 */
import { isString } from 'lodash';
import memize from 'memize';

/**
 * WordPress dependencies
 */
import { Fragment } from '@wordpress/element';
import {
	Button,
	Dashicon,
	Modal,
	SelectControl,
	TextControl,
} from '@wordpress/components';
import { compose, withState } from '@wordpress/compose';
import { withDispatch, withSelect } from '@wordpress/data';
import { __, sprintf } from '@wordpress/i18n';
import { dateI18n, format } from '@wordpress/date';

function getPeriod( queryArgs, config ) {
	if ( queryArgs.period ) {
		return queryArgs.period;
	}

	if ( config.query_args.period ) {
		return config.query_args.period.default;
	}
}

function getPeriodLabel( period ) {
	if ( ! period ) {
		return '';
	}

	const now = new window.Date();
	let start, end;

	switch ( period ) {
		case '24-hours':
			return __( '24 Hours', 'it-l10n-ithemes-security-pro' );
		case '30-days':
			start = dateI18n( 'M j', now.setDate( now.getDate() - 30 ) );
			end = dateI18n( 'M j' );
			break;
		case 'week':
			start = dateI18n( 'M j', now.setDate( now.getDate() - 7 ) );
			end = dateI18n( 'M j' );
			break;
		default:
			start = dateI18n( 'M j', period.start );
			end = dateI18n( 'M j', period.end );
			break;
	}

	return sprintf(
		/* translators: 1. The start time, 2. The end time. */
		__( '%1$s - %2$s', 'it-l10n-ithemes-security-pro' ),
		start,
		end
	);
}

const getDateOptions = memize( () => {
	return [
		{ value: '24-hours', label: __( '24 Hours', 'it-l10n-ithemes-security-pro' ) },
		{ value: 'week', label: __( '7 Days', 'it-l10n-ithemes-security-pro' ) },
		{ value: '30-days', label: __( '30 Days', 'it-l10n-ithemes-security-pro' ) },
		{ value: 'custom', label: __( 'Custom', 'it-l10n-ithemes-security-pro' ) },
	];
} );

const now = new window.Date();
const MIN = format( 'Y-m-d', now.setDate( now.getDate() - 60 ) );
const MAX = format( 'Y-m-d' );

function Date( {
	queryArgs,
	config,
	isOpen,
	periodOption,
	start,
	end,
	setState,
	update,
} ) {
	const period = getPeriod( queryArgs, config );
	const periodLabel = getPeriodLabel( period );
	periodOption = periodOption || ( isString( period ) ? period : 'custom' );

	const onApply = ( e ) => {
		e.preventDefault();

		let newPeriod;

		if ( 'custom' === periodOption ) {
			newPeriod = { start, end };
		} else {
			newPeriod = periodOption;
		}

		update( { ...queryArgs, period: newPeriod } );
		setState( { isOpen: false } );
	};

	return (
		<div className="itsec-card-header-date">
			<Button
				onClick={ () => setState( { isOpen: ! isOpen } ) }
				title={ periodLabel }
				aria-expanded={ isOpen }
				aria-label={ sprintf(
					/* translators: 1. The current search period or interval Eg, 24 hours. */
					__( '%s (click to change)', 'it-l10n-ithemes-security-pro' ),
					periodLabel
				) }
			>
				<span className="itsec-card-header-date__period">
					{ periodLabel }
				</span>
				<Dashicon
					icon="calendar"
					className="itsec-card-header-date__icon"
				/>
			</Button>
			{ isOpen && (
				<Modal
					title={ __( 'Change Date Period', 'it-l10n-ithemes-security-pro' ) }
					onRequestClose={ () => setState( { isOpen: false } ) }
				>
					<SelectControl
						options={ getDateOptions() }
						value={ periodOption }
						onChange={ ( newPeriod ) =>
							setState( { periodOption: newPeriod } )
						}
					/>
					{ periodOption === 'custom' && (
						<Fragment>
							<TextControl
								type="date"
								min={ MIN }
								max={ MAX }
								value={ start }
								onChange={ ( newStart ) =>
									setState( { start: newStart } )
								}
								label={ __( 'Start Date', 'it-l10n-ithemes-security-pro' ) }
								placeholder="YYYY-MM-DD"
							/>
							<TextControl
								type="date"
								min={ MIN }
								max={ MAX }
								value={ end }
								onChange={ ( newEnd ) =>
									setState( { end: newEnd } )
								}
								label={ __( 'End Date', 'it-l10n-ithemes-security-pro' ) }
								placeholder="YYYY-MM-DD"
							/>
						</Fragment>
					) }
					<Button isPrimary onClick={ onApply }>
						{ __( 'Apply', 'it-l10n-ithemes-security-pro' ) }
					</Button>
				</Modal>
			) }
		</div>
	);
}

export default compose( [
	withSelect( ( select, { card } ) => ( {
		queryArgs:
			select( 'ithemes-security/dashboard' ).getDashboardCardQueryArgs(
				card.id
			) || {},
	} ) ),
	withDispatch( ( dispatch, { card } ) => ( {
		update( queryArgs ) {
			return dispatch( 'ithemes-security/dashboard' ).queryDashboardCard(
				card.id,
				queryArgs
			);
		},
	} ) ),
	withState( {
		isOpen: false,
		periodOption: undefined,
		start: undefined,
		end: undefined,
	} ),
] )( Date );
