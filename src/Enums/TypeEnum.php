<?php

declare(strict_types=1);

namespace ReturnEarly\Dns\Enums;

use ReturnEarly\LaravelEnums\EnumHelpers;

enum TypeEnum: string
{
    use EnumHelpers;

    case A = 'A';
    case AAAA = 'AAAA';
    case AFSDB = 'AFSDB';
    case ANY = 'ANY';
    case APL = 'APL';
    case AXFR = 'AXFR';
    case CAA = 'CAA';
    case CERT = 'CERT';
    case CNAME = 'CNAME';
    case DHCID = 'DHCID';
    case DLV = 'DLV';
    case DNAME = 'DNAME';
    case DNSKEY = 'DNSKEY';
    case DS = 'DS';
    case HIP = 'HIP';
    case IPSECKEY = 'IPSECKEY';
    case IXFR = 'IXFR';
    case KEY = 'KEY';
    case KX = 'KX';
    case LOC = 'LOC';
    case MX = 'MX';
    case NAPTR = 'NAPTR';
    case NS = 'NS';
    case NSEC = 'NSEC';
    case NSEC3 = 'NSEC3';
    case NSEC3PARAM = 'NSEC3PARAM';
    case PTR = 'PTR';
    case RP = 'RP';
    case RRSIG = 'RRSIG';
    case SIG = 'SIG';
    case SOA = 'SOA';
    case SPF = 'SPF';
    case SRV = 'SRV';
    case SSHFP = 'SSHFP';
    case TA = 'TA';
    case TKEY = 'TKEY';
    case TSIG = 'TSIG';
    case TXT = 'TXT';

    public function toTypeName(): string
    {
        return $this->value;
    }

    public function toTypeId(): int
    {
        return match ($this) {
            self::A => 1,
            self::AAAA => 28,
            self::AFSDB => 18,
            self::ANY => 255,
            self::APL => 42,
            self::AXFR => 252,
            self::CAA => 257,
            self::CERT => 37,
            self::CNAME => 5,
            self::DHCID => 49,
            self::DLV => 32769,
            self::DNAME => 39,
            self::DNSKEY => 48,
            self::DS => 43,
            self::HIP => 55,
            self::IPSECKEY => 45,
            self::IXFR => 251,
            self::KEY => 25,
            self::KX => 36,
            self::LOC => 29,
            self::MX => 15,
            self::NAPTR => 35,
            self::NS => 2,
            self::NSEC => 47,
            self::NSEC3 => 50,
            self::NSEC3PARAM => 51,
            self::PTR => 12,
            self::RP => 17,
            self::RRSIG => 46,
            self::SIG => 24,
            self::SOA => 6,
            self::SPF => 99,
            self::SRV => 33,
            self::SSHFP => 44,
            self::TA => 32768,
            self::TKEY => 249,
            self::TSIG => 250,
            self::TXT => 16,
        };
    }

    public function toRFC(): string
    {
        return match ($this) {
            self::A => 'RFC 1035 (Address Record)',
            self::AAAA => 'RFC 3596 (IPv6 Address)',
            self::AFSDB => 'RFC 1183 (AFS Database Record)',
            self::ANY => 'RFC 1035 AKA "*" (Pseudo Record)',
            self::APL => 'RFC 3123 (Address Prefix List (Experimental)',
            self::AXFR => 'RFC 1035 (Authoritative Zone Transfer)',
            self::CAA => 'RFC 6844 (Certification Authority Authorization)',
            self::CERT => 'RFC 4398 (Certificate Record, PGP etc)',
            self::CNAME => 'RFC 1035 (Canonical Name Record (Alias))',
            self::DHCID => 'RFC 4701 (DHCP Identifier)',
            self::DLV => 'RFC 4431 (DNSSEC Lookaside Validation)',
            self::DNAME => 'RFC 2672 (Delegation Name Record, wildcard alias)',
            self::DNSKEY => 'RFC 4034 (DNS Key Record (DNSSEC))',
            self::DS => 'RFC 4034 (Delegation Signer (DNSSEC)',
            self::HIP => 'RFC 5205 (Host Identity Protocol)',
            self::IPSECKEY => 'RFC 4025 (IPSEC Key)',
            self::IXFR => 'RFC 1995 (Incremental Zone Transfer)',
            self::KEY => 'RFC 2535 & RFC 2930',
            self::KX => 'RFC 2230 (Key eXchanger)',
            self::LOC => 'RFC 1876 (Geographic Location)',
            self::MX => 'RFC 1035 (Mail eXchanger Record)',
            self::NAPTR => 'RFC 3403 (Naming Authority Pointer)',
            self::NS => 'RFC 1035 (Name Server Record)',
            self::NSEC => 'RFC 4034 (Next-secure Record (DNSSEC))',
            self::NSEC3 => 'RFC 5155 (NSEC Record v3 (DNSSEC Extension))',
            self::NSEC3PARAM => 'RFC 5155 (NSEC3 Parameters (DNSSEC Extension))',
            self::PTR => 'RFC 1035 (Pointer Record)',
            self::RP => 'RFC 1183 (Responsible Person)',
            self::RRSIG => 'RFC 4034 (DNSSEC Signature)',
            self::SIG => 'RFC 2535',
            self::SOA => 'RFC 1035 (Start of Authority Record)',
            self::SPF => 'RFC 4408 (Sender Policy Framework)',
            self::SRV => 'RFC 2782 (Service Locator)',
            self::SSHFP => 'RFC 4255 (SSH Public Key Fingerprint)',
            self::TA => '(DNSSEC Trusted Authorities)',
            self::TKEY => 'RFC 2930 (Secret Key)',
            self::TSIG => 'RFC 2845 (Transaction Signature)',
            self::TXT => 'RFC 1035 (Text Record)',
        };
    }

    public static function fromTypeId(int $type): self
    {
        return self::collection()
            ->first(fn (self $enum) => $enum->toTypeId() === $type);
    }

    public static function fromTypeName(string $type): self
    {
        return self::fromValue(mb_strtoupper($type));
    }
}
