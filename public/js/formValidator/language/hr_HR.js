(function($) {
    /**
     * Croatian Latin language package
     * Translated by @abraxas
     */
    FormValidation.I18n = $.extend(true, FormValidation.I18n, {
        'hr_HR': {
            base64: {
                'default': 'Molimo unesite važeći base 64 enkodiran'
            },
            between: {
                'default': 'Molimo unesite vrijednost između %s i %s',
                notInclusive: 'Molimo unesite vrijednost strogo između %s i %s'
            },
            bic: {
                'default': 'Molimo unesite ispravanii BIC broj'
            },
            callback: {
                'default': 'Molimo unesite važeću vrijednost'
            },
            choice: {
                'default': 'Molimo unesite važeću vrijednost',
                less: 'Molimo da odaberete minimalno %s opciju(a)',
                more: 'Molimo da odaberete maksimalno %s opciju(a)',
                between: 'Molimo odaberite %s - %s opcije(a)'
            },
            color: {
                'default': 'Molimo unesite ispravnu boju'
            },
            creditCard: {
                'default': 'Molimo unesite ispravani broj kreditne kartice'
            },
            cusip: {
                'default': 'Molimo unesite ispravani CUSIP broj'
            },
            cvv: {
                'default': 'Molimo unesite ispravani CVV broj'
            },
            date: {
                'default': 'Molimo unesite ispravani datum',
                min: 'Molimo unesite datum posle %s',
                max: 'Molimo unesite datum pre %s',
                range: 'Molimo unesite datum od %s do %s'
            },
            different: {
                'default': 'Molimo unesite drugu vrijednost'
            },
            digits: {
                'default': 'Molimo unesite samo cifre'
            },
            ean: {
                'default': 'Molimo unesite ispravani EAN broj'
            },
            ein: {
                'default': 'Molimo unesite ispravani EIN broj'
            },
            emailAddress: {
                'default': 'Molimo unesite važeću e-mail adresu'
            },
            file: {
                'default': 'Molimo unesite ispravaniu datoteku'
            },
            greaterThan: {
                'default': 'Molimo unesite vrijednost veću ili jednaku od %s',
                notInclusive: 'Molimo unesite vrijednost veću od %s'
            },
            grid: {
                'default': 'Molimo unesite ispravani GRId broj'
            },
            hex: {
                'default': 'Molimo unesite ispravani heksadecimalni broj'
            },
            iban: {
                'default': 'Molimo unesite ispravani IBAN broj',
                country: 'Molimo unesite ispravani IBAN broj %s',
                countries: {
                    AD: 'Andore',
                    AE: 'Ujedinjenih Arapskih Emirata',
                    AL: 'Albanije',
                    AO: 'Angole',
                    AT: 'Austrije',
                    AZ: 'Azerbejdžana',
                    BA: 'Bosne i Hercegovine',
                    BE: 'Belgije',
                    BF: 'Burkina Fasa',
                    BG: 'Bugarske',
                    BH: 'Bahraina',
                    BI: 'Burundija',
                    BJ: 'Benina',
                    BR: 'Brazila',
                    CH: 'Švajcarske',
                    CI: 'Obale slonovače',
                    CM: 'Kameruna',
                    CR: 'Kostarike',
                    CV: 'Zelenorotskih Ostrva',
                    CY: 'Kipra',
                    CZ: 'Češke',
                    DE: 'Nemačke',
                    DK: 'Danske',
                    DO: 'Dominike',
                    DZ: 'Alžira',
                    EE: 'Estonije',
                    ES: 'Španije',
                    FI: 'Finske',
                    FO: 'Farskih Ostrva',
                    FR: 'Francuske',
                    GB: 'Engleske',
                    GE: 'Džordžije',
                    GI: 'Giblartara',
                    GL: 'Grenlanda',
                    GR: 'Grčke',
                    GT: 'Gvatemale',
                    HR: 'Hrvatske',
                    HU: 'Mađarske',
                    IE: 'Irske',
                    IL: 'Izraela',
                    IR: 'Irana',
                    IS: 'Islanda',
                    IT: 'Italije',
                    JO: 'Jordana',
                    KW: 'Kuvajta',
                    KZ: 'Kazahstana',
                    LB: 'Libana',
                    LI: 'Lihtenštajna',
                    LT: 'Litvanije',
                    LU: 'Luksemburga',
                    LV: 'Latvije',
                    MC: 'Monaka',
                    MD: 'Moldove',
                    ME: 'Crne Gore',
                    MG: 'Madagaskara',
                    MK: 'Makedonije',
                    ML: 'Malija',
                    MR: 'Mauritanije',
                    MT: 'Malte',
                    MU: 'Mauricijusa',
                    MZ: 'Mozambika',
                    NL: 'Holandije',
                    NO: 'Norveške',
                    PK: 'Pakistana',
                    PL: 'Poljske',
                    PS: 'Palestine',
                    PT: 'Portugala',
                    QA: 'Katara',
                    RO: 'Rumunije',
                    RS: 'Srbije',
                    SA: 'Saudijske Arabije',
                    SE: 'Švedske',
                    SI: 'Slovenije',
                    SK: 'Slovačke',
                    SM: 'San Marina',
                    SN: 'Senegala',
                    TN: 'Tunisa',
                    TR: 'Turske',
                    VG: 'Britanskih Devičanskih Ostrva'
                }
            },
            id: {
                'default': 'Molimo unesite ispravani identifikacijski broj',
                country: 'Molimo unesite ispravani identifikacijski broj %s',
                countries: {
                    BA: 'Bosne i Herzegovine',
                    BG: 'Bugarske',
                    BR: 'Brazila',
                    CH: 'Švajcarske',
                    CL: 'Čilea',
                    CN: 'Kine',
                    CZ: 'Češke',
                    DK: 'Danske',
                    EE: 'Estonije',
                    ES: 'Španije',
                    FI: 'Finske',
                    HR: 'Hrvatske',
                    IE: 'Irske',
                    IS: 'Islanda',
                    LT: 'Litvanije',
                    LV: 'Letonije',
                    ME: 'Crne Gore',
                    MK: 'Makedonije',
                    NL: 'Holandije',
                    PL: 'Poljske',
                    RO: 'Rumunije',
                    RS: 'Srbije',
                    SE: 'Švedske',
                    SI: 'Slovenije',
                    SK: 'Slovačke',
                    SM: 'San Marina',
                    TH: 'Tajlanda',
                    ZA: 'Južne Afrike'
                }
            },
            identical: {
                'default': 'Molimo unesite istu vrijednost'
            },
            imei: {
                'default': 'Molimo unesite ispravani IMEI broj'
            },
            imo: {
                'default': 'Molimo unesite ispravani IMO broj'
            },
            integer: {
                'default': 'Molimo unesite ispravani broj'
            },
            ip: {
                'default': 'Molimo unesite ispravnu IP adresu',
                ipv4: 'Molimo unesite ispravnu IPv4 adresu',
                ipv6: 'Molimo unesite ispravnu IPv6 adresu'
            },
            isbn: {
                'default': 'Molimo unesite ispravani ISBN broj'
            },
            isin: {
                'default': 'Molimo unesite ispravani ISIN broj'
            },
            ismn: {
                'default': 'Molimo unesite ispravani ISMN broj'
            },
            issn: {
                'default': 'Molimo unesite ispravani ISSN broj'
            },
            lessThan: {
                'default': 'Molimo unesite vrijednost manju ili jednaku od %s',
                notInclusive: 'Molimo unesite vrijednost manju od %s'
            },
            mac: {
                'default': 'Molimo unesite ispravnu MAC adresu'
            },
            meid: {
                'default': 'Molimo unesite ispravani MEID broj'
            },
            notEmpty: {
                'default': 'Molimo unesite vrijednost'
            },
            numeric: {
                'default': 'Molimo unesite ispravani decimalni broj'
            },
            phone: {
                'default': 'Molimo unesite ispravani broj telefona',
                country: 'Molimo unesite ispravani broj telefona %s',
                countries: {
                    AE: 'Ujedinjenih Arapskih Emirata',
                    BG: 'Bugarske',
                    BR: 'Brazila',
                    CN: 'Kine',
                    CZ: 'Češke',
                    DE: 'Nemačke',
                    DK: 'Danske',
                    ES: 'Španije',
                    FR: 'Francuske',
                    GB: 'Engleske',
                    IN: 'Индија',
                    MA: 'Maroka',
                    NL: 'Holandije',
                    PK: 'Pakistana',
                    RO: 'Rumunije',
                    RU: 'Rusije',
                    SK: 'Slovačke',
                    TH: 'Tajlanda',
                    US: 'Amerike',
                    VE: 'Venecuele'
                }
            },
            regexp: {
                'default': 'Molimo unesite vrijednost koja se poklapa sa uzorkom'
            },
            remote: {
                'default': 'Molimo unesite ispravnu vrijednost'
            },
            rtn: {
                'default': 'Molimo unesite ispravani RTN broj'
            },
            sedol: {
                'default': 'Molimo unesite ispravani SEDOL broj'
            },
            siren: {
                'default': 'Molimo unesite ispravani SIREN broj'
            },
            siret: {
                'default': 'Molimo unesite ispravani SIRET broj'
            },
            step: {
                'default': 'Molimo unesite ispravani korak od %s'
            },
            stringCase: {
                'default': 'Molimo unesite samo mala slova',
                upper: 'Molimo unesite samo velika slova'
            },
            stringLength: {
                'default': 'Molimo unesite vrijednost sa ispravnom dužinom',
                less: 'Molimo unesite manje od %s znakova',
                more: 'Molimo unesite više od %s znakova',
                between: 'Molimo unesite vrijednost dužine između %s i %s znakova'
            },
            uri: {
                'default': 'Molimo unesite ispravani URI'
            },
            uuid: {
                'default': 'Molimo unesite ispravani UUID broj',
                version: 'Molimo unesite ispravnu verziju UUID %s broja'
            },
            vat: {
                'default': 'Molimo unesite ispravani VAT broj',
                country: 'Molimo unesite ispravani VAT broj %s',
                countries: {
                    AT: 'Austrije',
                    BE: 'Belgije',
                    BG: 'Bugarske',
                    BR: 'Brazila',
                    CH: 'Švajcarske',
                    CY: 'Kipra',
                    CZ: 'Češke',
                    DE: 'Nemačke',
                    DK: 'Danske',
                    EE: 'Estonije',
                    ES: 'Španije',
                    FI: 'Finske',
                    FR: 'Francuske',
                    GB: 'Engleske',
                    GR: 'Grčke',
                    EL: 'Grčke',
                    HU: 'Mađarske',
                    HR: 'Hrvatske',
                    IE: 'Irske',
                    IS: 'Islanda',
                    IT: 'Italije',
                    LT: 'Litvanije',
                    LU: 'Luksemburga',
                    LV: 'Letonije',
                    MT: 'Malte',
                    NL: 'Holandije',
                    NO: 'Norveške',
                    PL: 'Poljske',
                    PT: 'Portugala',
                    RO: 'Romunje',
                    RU: 'Rusije',
                    RS: 'Srbije',
                    SE: 'Švedske',
                    SI: 'Slovenije',
                    SK: 'Slovačke',
                    VE: 'Venecuele',
                    ZA: 'Južne Afrike'
                }
            },
            vin: {
                'default': 'Molimo unesite ispravani VIN broj'
            },
            zipCode: {
                'default': 'Molimo unesite ispravani poštanski broj',
                country: 'Molimo unesite ispravani poštanski broj %s',
                countries: {
                    AT: 'Austrije',
                    BG: 'Bugarske',
                    BR: 'Brazila',
                    CA: 'Kanade',
                    CH: 'Švajcarske',
                    CZ: 'Češke',
                    DE: 'Nemačke',
                    DK: 'Danske',
                    ES: 'Španije',
                    FR: 'Francuske',
                    GB: 'Engleske',
                    IE: 'Irske',
                    IN: 'Индија',
                    IT: 'Italije',
                    MA: 'Maroka',
                    NL: 'Holandije',
                    PL: 'Poljske',
                    PT: 'Portugala',
                    RO: 'Rumunije',
                    RU: 'Rusije',
                    SE: 'Švedske',
                    SG: 'Singapura',
                    SK: 'Slovačke',
                    US: 'Amerike'
                }
            }
        }
    });
}(jQuery));
